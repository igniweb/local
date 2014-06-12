<?php

use Local\Services\SocialWall\Repositories\Models\SocialAccount;
use Local\Services\SocialWall\Repositories\Models\SocialAccountMeta;

class SocialAccountsTableSeeder extends Seeder {

    private $facebookPageId;

    public function run()
    {
        SocialAccount::truncate();
        SocialAccountMeta::truncate();

        $lines = explode("\n", str_replace("\r\n", "\n", trim(file_get_contents(__DIR__ . '/stubs/social_wall.csv'), "\n")));
        if (count($lines) > 1)
        {   // Skip header
            array_shift($lines);
            foreach ($lines as $line)
            {
                $this->parseLine($line);
            }
        }
    }

    public function parseLine($line)
    {
        $fields = explode(",", $line);
        if ( ! empty($fields[0]))
        {
            array_map([$this, 'cleanUrl'], $fields);

            $name      = trim($fields[0]);
            $twitter   = ! empty($fields[1]) ? $this->getTwitter($fields[1])   : null;
            $instagram = ! empty($fields[2]) ? $this->getInstagram($fields[2]) : null;
            $facebook  = ! empty($fields[3]) ? $this->getFacebook($fields[3])  : null;

            if ( ! empty($twitter) or ! empty($instagram) or ! empty($facebook))
            {
                $socialAccount = SocialAccount::create([
                    'name'          => $name,
                    'slug'          => Str::slug($name),
                    'twitter'       => $twitter,
                    'instagram'     => $instagram,
                    'facebook'      => $facebook,
                ]);

                if ( ! empty($socialAccount))
                {
                    $this->setMetas($socialAccount);

                    return $socialAccount;
                }
            }
        }

        return false;
    }

    private function getTwitter($url)
    {
        if (strpos($url, 'https://twitter.com/') === 0)
        {
            return substr($url, 20);
        }

        return null;
    }

    private function getInstagram($url)
    {
        if (strpos($url, 'http://instagram.com/') === 0)
        {
            return substr($url, 21);
        }

        return null; 
    }

    private function getFacebook($url)
    {
        $this->facebookPageId = null;

        if (strpos($url, 'https://www.facebook.com/') === 0)
        {
            $url = substr($url, 25);
            if (strpos($url, 'pages/') === 0)
            {
                $segments = explode('/', $url);

                if ( ! empty($segments[1]))
                {
                    if ( ! empty($segments[2]))
                    {
                        $this->facebookPageId = $segments[2];
                    }

                    return $segments[1];
                };
            }
            else
            {
                return ! empty($url) ? $this->removeGet($url) : null;
            }
        }

        return null;
    }

    public function cleanUrl($url)
    {   // Clean a bit and remove last trailing slash
        $url = trim($url, " /");
        // Remove GET data
        $url = $this->removeGet($url);

        return $url;
    }

    private function removeGet($url)
    {
        $get = explode('?', $url);
        if (count($get) > 0)
        {
            $url = $get[0];
        }
        $url = rtrim($url, " /");

        return $url;
    }

    private function setMetas($socialAccount)
    {
        // Continue here...
        // Extract all metas for account
        // - Instagram: {user-id} + name + icon
        // - Twitter: name + icon
        // - Facebook: {page-id} ou {user-id} + name + icon
        // Delete extra data from social_items table
        // SocialItemRepository must decorate() or present() an account with typed metas
        $types = ['twitter', 'instagram', 'facebook'];
        foreach ($types as $type)
        {
            if ( ! empty($socialAccount->$type))
            {   // Build dedicated provider
                $provider     = '\Local\Services\SocialWall\MetasProviders\\' . ucfirst($type) . 'MetasProvider';
                $instance     = new $provider;

                $accountMetas = [];
                if (($type == 'facebook') and ! empty($this->facebookPageId))
                {   // Special treatment for facebook pages
                    $accountMetas[] = [
                        'account_id' => $socialAccount->id,
                        'type'       => 'facebook',
                        'key'        => 'page_id',
                        'value'      => $this->facebookPageId,
                    ];
                }

                // Get metas from dedicated provider
                $accountMetas = array_merge($accountMetas, $instance->getMetas($socialAccount));
                if ( ! empty($accountMetas))
                {   // Add in database
                    foreach ($accountMetas as $accountMeta)
                    {
                        SocialAccountMeta::create($accountMeta);
                    }
                }
            }
        }
    }

}
