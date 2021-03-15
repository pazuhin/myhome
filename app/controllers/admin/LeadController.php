<?php


namespace app\controllers\admin;


use app\models\Lead;

class LeadController extends AppController
{
    /**
     * @throws \Exception
     */
    public function changeStatusAction()
    {

        $leadId = (int)htmlspecialchars(trim($_POST['leadId'])) ?? null;
        $status = htmlspecialchars(trim($_POST['status'])) ?? null;

        $lead = new Lead();
        if ($leadId) {
            $leadData = $lead->findById($leadId);
            if (!$leadData) {
                throw new \Exception('Заявка не найдена');
            }
        }
        if (!$lead->updateStatus($leadId, $status)) {
            throw new \Exception('Ошибка сохранения');
        }

        if ($this->isAjax()) {
            $this->loadView('lead', $leadData);
        };
    }
}