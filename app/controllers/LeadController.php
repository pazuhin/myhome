<?php


namespace app\controllers;


use app\models\Lead;
use core\base\Controller;
use core\libs\Pagination;

class LeadController extends Controller
{
    /**
     * @return bool
     */
    public function createAction()
    {
        $regionName = htmlspecialchars(trim($_POST['regionName'])) ?? null;
        $groupName = htmlspecialchars(trim($_POST['groupName'])) ?? null;
        $typeName = htmlspecialchars(trim($_POST['typeName'])) ?? null;
        $msg = htmlspecialchars(trim($_POST['msg'])) ?? null;
        $lead = new Lead();

        $lead->load([
            'regionName' => $regionName,
            'groupName' => $groupName,
            'typeName' => $typeName,
            'message' => $msg,
            'userId' => htmlspecialchars(trim($_SESSION['user']['id']))
        ]);

        try {
            if (!$lead->save('leads')) {
                throw new \Exception('Ошибка сохранения');
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Ошибка сохранения';
        };
    }

    public function listAction()
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

    public function viewAction()
    {
        $id = (int)$_GET['id'] ?? null;
        if ($id) {
            $lead = new Lead();
            $leadInfo = $lead->findById($id);
            if (!$leadInfo) {
                return false;
            }
        }
        $statuses = Lead::STATUSES;
        $this->set(compact('leadInfo', 'statuses'));
    }
}