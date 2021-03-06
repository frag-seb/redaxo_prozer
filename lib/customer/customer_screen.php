<?php

class pz_customer_screen
{
    public $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    // --------------------------------------------------------------- Listviews

    public function getListView($p = [])
    {
        $p['linkvars']['customer_id'] = $this->customer->getVar('id');

        $edit_link = "javascript:pz_loadPage('customer_form','".pz::url('screen', 'projects', 'customers', array_merge($p['linkvars'], ['mode' => 'edit_customer', 'customer_id' => $this->customer->getId()]))."')";

        $return = '
          <article>
            <header>
              <a class="detail clearfix" href="'.$edit_link.'">
                <figure><img src="'.$this->customer->getInlineImage().'" width="40" height="40" alt="" /></figure>
                <hgroup>
                  <h3 class="hl7"><span class="title">'.$this->customer->getVar('name').'</span></h3>
                </hgroup>
                <span class="label">Label</span>
              </a>
            </header>
            <footer>
              <a class="bt2" href="'.$edit_link.'">'.pz_i18n::msg('customer_edit').'</a>
            </footer>
          </article>
        ';

        return $return;
    }

    // --------------------------------------------------------------- Pageviews


    // --------------------------------------------------------------- Formviews


    public function getDeleteForm($p = [])
    {
        $header = '
	        <header>
	          <div class="header">
	            <h1 class="hl1">'.pz_i18n::msg('delete_customer').'</h1>
	          </div>
	        </header>';

        $return = $header.'<p class="xform-info">'.pz_i18n::msg('customer_deleted', htmlspecialchars($p['customer_name'])).'</p>';
        $return .= pz_screen::getJSLoadFormPage('customers_list', 'customers_search_form', pz::url('screen', 'projects', 'customers', ['mode' => 'list']));
        $return = '<div id="customer_form"><div id="customer_delete" class="design1col xform-delete">'.$return.'</div></div>';

        return $return;
    }

    public function getEditForm($p = [])
    {
        $header = '
        <header>
          <div class="header">
            <h1 class="hl1">'.pz_i18n::msg('customer_edit').': '.$this->customer->getName().'</h1>
          </div>
        </header>';

        $xform = new rex_xform();
        // $xform->setDebug(TRUE);

        $xform->setObjectparams('main_table', 'pz_customer');
        $xform->setObjectparams('main_id', $this->customer->getId());
        $xform->setObjectparams('main_where', 'id='.$this->customer->getId());
        $xform->setObjectparams('getdata', true);
        $xform->setObjectparams('form_action', "javascript:pz_loadFormPage('customer_edit','customer_edit_form','".pz::url('screen', 'projects', 'customers', ['mode' => 'edit_customer'])."')");
        $xform->setObjectparams('form_id', 'customer_edit_form');
        $xform->setObjectparams('form_showformafterupdate', 1);
        $xform->setHiddenField('customer_id', $this->customer->getId());
        $xform->setValueField('objparams', ['fragment', 'pz_screen_xform.tpl']);

        $xform->setValueField('pz_image_screen', ['image_inline', pz_i18n::msg('photo'), pz_customer::getDefaultImage()]);

        $xform->setValueField('text', ['name', pz_i18n::msg('customer_name'), '', '0']);
        $xform->setValueField('textarea', ['description', pz_i18n::msg('customer_description'), '', '0']);

        $xform->setValueField('datestamp', ['created', 'mysql', '', '0', '1']);
        $xform->setValueField('datestamp', ['updated', 'mysql', '', '0', '0']);

        $xform->setValueField('checkbox', ['archived', pz_i18n::msg('customer_archived'), '', '0']);
        $xform->setValidateField('empty', ['name', pz_i18n::msg('error_customer_name_empty')]);

        $xform->setActionField('db', ['pz_customer', 'id='.$this->customer->getId()]);

        $return = $xform->getForm();

        if ($xform->getObjectparams('actions_executed')) {
            $this->customer->update();
            $return = $header.'<p class="xform-info">'.pz_i18n::msg('customer_updated').'</p>'.$return;
            $return .= pz_screen::getJSLoadFormPage('customers_list', 'customer_search_form', pz::url('screen', 'projects', 'customers', ['mode' => 'list']));
        } else {
            $return = $header.$return;
        }

        if ($p['show_delete']) {
            $delete_link = pz::url('screen', 'projects', 'customers', ['customer_id' => $this->customer->getId(), 'mode' => 'delete_customer']);
            $return .= '<div class="xform">
				<p><a class="bt17" onclick="check = confirm(\''.
                str_replace(["'", "\n", "\r"], ['', '', ''], pz_i18n::msg('customer_confirm_delete', htmlspecialchars($this->customer->getName()))).
                '\'); if (check == true) pz_loadPage(\'customer_form\',\''.
                $delete_link.'\')" href="javascript:void(0);">- '.pz_i18n::msg('delete_customer').'</a></p>
				</div>';
        }

        $return = '<div id="customer_form"><div id="customer_edit" class="design1col xform-edit">'.$return.'</div></div>';

        return $return;
    }

    public static function getAddForm($p = [])
    {
        $return = '
	        <header>
	          <div class="header">
	            <h1 class="hl1">'.pz_i18n::msg('customer_add').'</h1>
	          </div>
	        </header>';

        $xform = new rex_xform();
        // $xform->setDebug(TRUE);

        $xform->setObjectparams('main_table', 'pz_customer');
        $xform->setObjectparams('form_action', "javascript:pz_loadFormPage('customer_add','customer_add_form','".pz::url('screen', 'projects', 'customers', ['mode' => 'add_customer'])."')");
        $xform->setObjectparams('form_id', 'customer_add_form');
        $xform->setValueField('objparams', ['fragment', 'pz_screen_xform.tpl']);
        foreach ($p['linkvars'] as $k => $v) {
            $xform->setHiddenField($k, $v);
        }

        $xform->setValueField('pz_image_screen', ['image_inline', pz_i18n::msg('photo'), pz_customer::getDefaultImage()]);

        $xform->setValueField('text', ['name', pz_i18n::msg('customer_name'), '', '0']);
        $xform->setValueField('textarea', ['description', pz_i18n::msg('customer_description'), '', '0']);

        $xform->setValueField('datestamp', ['created', 'mysql', '', '0', '1']);
        $xform->setValueField('datestamp', ['updated', 'mysql', '', '0', '0']);

        $xform->setValueField('checkbox', ['archived', pz_i18n::msg('customer_archived'), '', '0']);
        $xform->setValidateField('empty', ['name', pz_i18n::msg('error_customer_name_empty')]);

        $xform->setActionField('db', []);
        $return .= $xform->getForm();

        if ($xform->getObjectparams('actions_executed')) {
            $customer_id = $xform->getObjectparams('main_id');
            if ($customer = pz_customer::get($customer_id)) {
                $customer->create();
            }
            $return .= '<p class="xform-info">'.pz_i18n::msg('customer_added').'</p>';
            $return .= pz_screen::getJSLoadFormPage('customers_list', 'customer_search_form', pz::url('screen', 'projects', 'customers', ['mode' => 'list']));
        }
        $return = '<div id="customer_form"><div id="customer_add" class="design1col xform-add">'.$return.'</div></div>';

        return $return;
    }
}
