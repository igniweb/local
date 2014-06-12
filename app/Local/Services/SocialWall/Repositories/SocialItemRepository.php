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

    public function paginate($limit, $offset = 0)
    {
        return $this->model->orderBy('feeded_at', 'desc')->skip($limit * $offset)->take($limit)->get();
    }

}
