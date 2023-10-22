<?php


namespace App\ViewModels;

class PaginationResultResponse
{

    public $current_page;
    public $data;
    public $last_page;
    public $total;

    public function __construct($pagination)
    {
        $this->current_page = $pagination->currentPage();
        $this->data = $pagination->items();
        $this->current_page = $pagination->lastPage();
        $this->total = $pagination->total();
    }

}
