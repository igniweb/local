<?php namespace Local\Services\SocialWall\Commands;

use Exception;
use Illuminate\Console\Command;
use InvalidArgumentException;
use Local\Services\SocialWall\Repositories\SocialUserRepository;
use Symfony\Component\Console\Input\InputOption;

class FetchCommand extends Command {

    protected $name = 'local:social-wall-fetch';

    protected $description = 'Fetch social items in live';

    protected $socialUserRepository;

    private $socialWall = null;

    public function __construct(SocialUserRepository $socialUserRepository)
    {
        parent::__construct();

        $this->socialUserRepository = $socialUserRepository;
    }

    public function fire()
    {
        $type  = $this->option('type');
        $debug = $this->option('debug');

        try
        {
            $accounts = $this->socialUserRepository->getAccounts($type);
        }
        catch (InvalidArgumentException $exception)
        {
            $this->error($exception->getMessage());
        }

        if ( ! empty($accounts))
        {
            $this->createSocialWall($type);
            if ($debug)
            {
                $this->comment('Fetch social items [' . $type . ']');
            }

            foreach ($accounts as $id => $user)
            {
                if ($debug)
                {
                    $this->line('Fetch [' . $user['name'] . '] account');
                }

                $this->socialWall->fetch($id, $user);
                if ($this->option('dry-run'))
                {
                    print_r($this->socialWall->getItems());
                }
                else
                {
                    $this->socialWall->save();
                }
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

        $this->socialWall = new \Local\Services\SocialWall\SocialWall(
            $fetcher,
            new \Local\Services\SocialWall\Repositories\SocialItemRepository(new \Local\Services\SocialWall\Repositories\Models\SocialItem)
        );
    }
}
