<?php
/**
* SE Manager
*
* Copyright 2012 by Ivan Klimchuk <ivan@klimchuk.com>
 *
 * SE Manager is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * SE Manager is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * SE Manager; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package semanager
 * @subpackage processors
 */

class modSEManagerGetCategoryListProcessor extends modObjectGetListProcessor {

    public $classKey = 'modCategory';
    //public $languageTopics = array('');
    //public $permission = '';
    public $defaultSortField = 'category';

    function getData() {
        $data = array();

        //$type = 'mod'.ucfirst($this->getProperty('type'));

        $limit = intval($this->getProperty('limit'));
        $start = intval($this->getProperty('start'));

        $c = $this->modx->newQuery($this->classKey);

        // ??? выбрать только категории, которые относятся к этому типу элементов



        $c = $this->prepareQueryBeforeCount($c);
        $data['total'] = $this->modx->getCount($this->classKey,$c);
        $c = $this->prepareQueryAfterCount($c);

        $sortClassKey = $this->getSortClassKey();
        $sortKey = $this->modx->getSelectColumns($sortClassKey,$this->getProperty('sortAlias',$sortClassKey),'',array($this->getProperty('sort')));
        if (empty($sortKey)) $sortKey = $this->getProperty('sort');
        $c->sortby($sortKey,$this->getProperty('dir'));
        if ($limit > 0) {
            $c->limit($limit,$start);
        }

        $c->select('id,category');

        $data['results'] = $this->modx->getCollection($this->classKey,$c);
        return $data;
    }

}

return 'modSEManagerGetCategoryListProcessor';

 /*
if (!empty($addall)) {
    $list = array(array('id' => 0, 'name' => $modx->lexicon('ms.combo.all')));
}
else {
    $list = array();
}

 */