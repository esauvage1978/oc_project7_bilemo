<?php

namespace App\Representation;

use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Type;


class Users extends Representation
{
    /**
     * @Type("array<App\Entity\User>")
     */
    public $data;

    public function __construct(Pagerfanta $data, ?string $wordsearch)
    {
        $this->data = $data->getCurrentPageResults();

        $this->addMeta('limit', $data->getMaxPerPage());
        $this->addMeta('current_items', count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        $wordsearch!==null && $this->addMeta('word_search', $wordsearch);
    }

}
