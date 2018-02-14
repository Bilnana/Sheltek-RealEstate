<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 4.12.17.
 * Time: 14.39
 */

namespace Drupal\search_blog\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SearchBlogForm extends FormBase
{
    public function getFormId()
    {
        return 'search_blog_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form[ '#method' ] = 'GET';

        $form[ 'search' ] = array(
            '#type'        => 'textfield',
            '#placeholder' =>t('Search...'),
            '#required' => TRUE,
        );

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Send'),
            '#button_type' => 'primary',
        );

        return $form;
    }

    public function buildContent()
    {
        $query = \Drupal::database()->select( 'node_field_data', 'n' );
        $query->condition( 'n.type', 'blog', '=' );


        $query->addField( 'n', 'nid' );


        $data = [];

        $results = $query->execute()->fetchAll();

        foreach ( $results as $result ) {
            $data[] = [
                'nid'       => $result->nid,
            ];
        }

        return $data;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state); // TODO: Change the autogenerated stub
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $render[] = [
            '#theme' => 'search_blog',
            '#content' => $this->buildContent(),
            '#cache' => [
                'max-age' => 0,
            ],
        ];
        return $render;
    }

}