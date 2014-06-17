<?php namespace Local\Services\SocialWall\Repositories;

class SocialItemRepository {

    protected $model;

    public function __construct(Models\SocialItem $model)
    {
        $this->model = $model;
    }

    public function store(array $items)
    {
        $stored = 0;
        foreach ($items as $item)
        {
            $socialItem = $this->findByTypeAndTypeId($item['type'], $item['type_id']);
            if (empty($socialItem))
            {
                $created = $this->model->create($item);
                if ( ! empty($created))
                {
                    $stored++;
                }
            }
            else
            {
                $stored++;
            }
        }

        return ($stored == count($items)) ? true : false;
    }

    public function findByTypeAndTypeId($type, $typeId)
    {
        return $this->model->where('type', '=', $type)->where('type_id', '=', $typeId)->first();
    }

    public function paginate($type, $accountId, $page = 0, $limit = 20)
    {
        $query = $this->model->orderBy('feeded_at', 'desc');

        if ($type != 'all')
        {
            $query = $query->where('type', '=', $type);
        }
        if ($accountId != 'all')
        {
            $query = $query->where('account_id', '=', $accountId);
        }

        return $query->skip($limit * $page)->take($limit)->get();
    }

}
