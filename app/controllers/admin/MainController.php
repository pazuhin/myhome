<?php

namespace app\controllers\admin;


use app\models\Lead;
use core\libs\Pagination;

class MainController extends AppController
{

    public function indexAction()
    {
        $lead = new Lead();
        $leadsCount = $lead->getLeadsCount();

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $countRecords = Pagination::COUNT_RECORDS;
        $pagination = new Pagination($page, $countRecords, $leadsCount);
        $startPage = $pagination->getStart();

        $leads = $lead->getList($countRecords, $startPage);

        $this->set(compact('leads', 'pagination'));
    }
}