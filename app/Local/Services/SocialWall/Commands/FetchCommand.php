<?php namespace Local\Services\SocialWall\Commands;

use Exception;
use Illuminate\Console\Command;
use InvalidArgumentException;
use Local\Services\SocialWall\Repositories\SocialAccountRepository;
use Symfony\Component\Console\Input\InputOption;

class FetchCommand extends Command {

    protected $name = 'local:social-wall-fetch';

    protected $description = 'Fetch social items in live';

    protected $socialAccountRepository;

    private $socialWall = null;

    public function __construct(SocialAccountRepository $socialAccountRepository)
    {
        parent::__construct();

        $this->socialAccountRepository = $socialAccountRepository;
    }

    public function fire()
    {
        $type  = $this->option('type');
        $debug = $this->option('debug');

        $accounts = $this->getAccountsByType($type);
        if ( ! empty($accounts))
        {
            $this->createSocialWall($type);
            if ($debug)
            {
                $this->comment('Fetch social items [' . $type . ']');
            }

            foreach ($accounts as $id => $account)
            {
                $this->fetchAndSaveAccount($id, $account, $debug);
            }
        }
        else
        {
            if ($debug)
            {
                $this->error('No account to fetch!');
            }
        }
    }

    protected function getOptions()
    {
        return [
            ['type', null, InputOption::VALUE_OPTIONAL, 'Type of the social feeds to fetch', 'twitter'],
            ['debug', null, InputOption::VALUE_NONE, 'Turn debug mode on', null],
            ['dry-run', null, InputOption::VALUE_NONE, 'Dump fetched items', null],
        ];
    }

    private function getAccountsByType($type)
    {
        try
        {
            $accounts = $this->socialAccountRepository->getByType($type);
        }
        catch (InvalidArgumentException $exception)
        {
            $this->error($exception->getMessage());
            exit;
        }

        return $accounts;
    }

    private function fetchAndSaveAccount($id, $account, $debug)
    {
        if ($debug)
        {
            $this->line('Fetch [' . $account['name'] . '] account');
        }

        $this->socialWall->fetch($id, $account);
        $items = $this->socialWall->getItems();
        if ($this->option('dry-run'))
        {
            print_r($items);
        }
        else
        {
            try
            {
                $saved = $this->socialWall->save();
                if ($debug)
                {
                    if ($saved)
                    {
                        $this->line('Social items saved successfully (' . count($items) . ')');
                    }
                    else
                    {
                        $this->error('An error occured while saving items');
                    }
                }
            }
            catch (Exception $exception)
            {
                $this->line('Nothing to save');
            }
        }
    }

    private function createSocialWall($type)
    {
        if ( ! empty($this->socialWall))
        {
            return;
        }

        switch ($type)
        {
            case 'twitter':
                $fetcher = new \Local\Services\SocialWall\Fetchers\TwitterFetcher;
                break;
            case 'instagram':
                $fetcher = new \Local\Services\SocialWall\Fetchers\InstagramFetcher;
                break;
            case 'facebook':
                $fetcher = new \Local\Services\SocialWall\Fetchers\FacebookFetcher;
                break;
            default:
                $this->error('Cannot create fetcher for [' . $type . ']');
                exit;
        }

        $this->socialWall = new \Local\Services\SocialWall\SocialWall($fetcher, new \Local\Services\SocialWall\Repositories\SocialItemRepository(new \Local\Services\SocialWall\Repositories\Models\SocialItem));
    }

}
