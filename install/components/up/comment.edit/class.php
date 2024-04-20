<?php

class CommentEditComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchComment();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		global $USER;
		$arParams['USER_ID'] = (int)$USER->getId();

		if (!request()->get('comment_id') || (int)request()->get('comment_id') <= 0)
		{
			$arParams['COMMENT_ID'] = null;
		}
		else
		{
			$arParams['COMMENT_ID'] = (int)request()->get('comment_id');
		}

		return $arParams;
	}

	protected function fetchComment()
	{
		$query = \Up\Ukan\Model\FeedbackTable::query();

		$query->setSelect(['*', 'TASK'])->where('ID', $this->arParams['COMMENT_ID']);

		$this->arResult['COMMENT'] = $query->fetchObject();



	}

}