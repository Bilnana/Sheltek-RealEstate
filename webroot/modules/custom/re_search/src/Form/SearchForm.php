<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 13.12.17.
 * Time: 09.41
 */

namespace Drupal\re_search\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;



class SearchForm extends FormBase
{
    public function getFormId()
    {
        return 're_search_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = [];

        $form['#method'] = 'GET';

        $form['filters'] = [
            '#type' => 'fieldset',
            '#title' => t('filters'),
            '#collapsible' => true,
            '#attributes' => array('class' => array('inline')),
        ];

        //  Bedroom

        $options = [
            0 => 'No. of Bedroom',
            1 => '1 room',
            2 => '2 room',
            3 => '3 room',
            4 => '4 room',
            5 => '5 room',
            6 => 'more then 5'
        ];

        $form['filters']['sort'] = [
            '#type' => 'select',
            '#options' => $options,
            '#default_value' => isset($_GET['bedroom']) ? $_GET['bedroom'] : '',
        ];

        //Bathroom

        $options = [
            0 => 'No. of Bathroom',
            1 => '1 bath',
            2 => '2 bath',
            3 => '3 bath',
            4 => '4 bath',
            5 => '5 bath',
            6 => 'more then 5'
        ];

        $form['filters']['bathsort'] = [
            '#type' => 'select',
            '#options' => $options,
            '#default_value' => isset($_GET['bathroom']) ? $_GET['bathroom'] : '',
        ];


        //Min and max

        $form['filters']['min'] = array(
            '#type' => 'number',
            '#placeholder' => t('Min area (sqft)'),
            '#min' => 0,
            '#max' => 500,
            '#default_value' => isset($_GET['min']) ? $_GET['min'] : '',
        );


        $form['filters']['max'] = array(
            '#type' => 'number',
            '#placeholder' => t('Max area (sqft)'),
            '#min' => 500,
            '#max' => 10000,
            '#default_value' => isset($_GET['max']) ? $_GET['max'] : '',
        );



        $options = [
            0 => 'Location',
            'Beograd' => [
                1 => 'Dorcol',
                2 => 'Banjica',
                3 => 'Konjarnik',
            ],
            'Novi Sad' => [
                4 => 'Liman',
                5 => 'Detelinara',
                6 => 'Grbavica'
            ],

        ];


        $form['filters']['location'] = [
            '#type' => 'select',
            '#options' => $options,
            '#default_value' => isset($_GET['location']) ? $_GET['location'] : '',
        ];

        //Price range

        $form ['filters']['min_price'] = array(
            '#type' => 'number',
            '#placeholder' => t('Min'),
            '#default_value' => isset( $_GET[ 'min_price' ] ) ? $_GET[ 'min_price' ] : '',
        );

        $form ['filters']['max_price'] = array(
            '#type' => 'number',
            '#placeholder' => t('Max'),
            '#default_value' => isset( $_GET[ 'max_price' ] ) ? $_GET[ 'max_price' ] : '',
        );




        $form['filters']['actions']['#type'] = 'actions';
        $form['filters']['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Search'),
        ];

        $data = $this->buildContent();

        $form['#content']['data'] = $data;

        $form['#theme'] = 're_search';

        $form['pager'] = array(
            '#type' => 'pager',
        );

        $form['#cache'] = ['max-age' => 0,];

        return $form;

    }

    private function buildContent()
    {


        $query = \Drupal::database()->select('node_field_data', 'n');
        $query->condition('n.type', 'property', '=');

        //Bedroom

        $query->innerJoin('node__field_bedroom', 'nfb', 'n.nid = nfb.entity_id');


        $sort = 0;
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }

        if ($sort == 0) {
            $query->condition('field_bedroom_value', '1', '>=');
        } else if ($sort == 1) {
            $query->condition('field_bedroom_value', '1', '=');
        } else if ($sort == 2) {
            $query->condition('field_bedroom_value', '2', '=');
        } else if ($sort == 3) {
            $query->condition('field_bedroom_value', '3', '=');
        } else if ($sort == 4) {
            $query->condition('field_bedroom_value', '4', '=');
        } else if ($sort == 5) {
            $query->condition('field_bedroom_value', '5', '=');
        } else if ($sort == 6) {
            $query->condition('field_bedroom_value', '5', '>');
        }

        //Bathroom

        $query->innerJoin('node__field_bathroom', 'nf', 'n.nid = nf.entity_id');


        $bathsort = 0;
        if (isset($_GET['bathsort'])) {
            $bathsort = $_GET['bathsort'];
        }

        if ($bathsort == 0) {
            $query->condition('field_bathroom_value', '1', '>=');
        } else if ($bathsort == 1) {
            $query->condition('field_bathroom_value', '1', '=');
        } else if ($bathsort == 2) {
            $query->condition('field_bathroom_value', '2', '=');
        } else if ($bathsort == 3) {
            $query->condition('field_bathroom_value', '3', '=');
        } else if ($bathsort == 4) {
            $query->condition('field_bathroom_value', '4', '=');
        } else if ($bathsort == 5) {
            $query->condition('field_bathroom_value', '5', '=');
        } else if ($bathsort == 6) {
            $query->condition('field_bathroom_value', '5', '>');
        }

        //max and min

        $query->innerJoin('node__field_area', 'fa', 'n.nid = fa.entity_id');

        $min = $_GET['min'];
        if (isset($min)) {
            $query->condition('fa.field_area_value', $min, '>=');
        } else {
            $query->condition('fa.field_area_value', '0', '>=');
        }

        $max = $_GET['max'];
        if (!empty($max)) {
            if (isset($max)) {
                $query->condition('fa.field_area_value', $max, '<=');
            }
        }

        //Price

        $query->innerJoin('node__field_price', 'fp', 'n.nid = fp.entity_id');

        $min_price = $_GET[ 'min_price' ];

        if ( isset( $min_price ) ) {
            $query->condition( 'fp.field_price_value', $min_price, '>=' );
        }


        $max_price = $_GET['max_price'];
        if (!empty($max_price)) {
            if (isset($max_price)) {
                $query->condition('fp.field_price_value', $max_price, '<=');
            }
        }

        //Working location search

        $query->innerJoin('node__field_location', 'fl', 'n.nid = fl.entity_id');
        $query->leftJoin('taxonomy_term_field_data', 'tfd', 'fl.field_location_target_id = tfd.tid');

        $location = 0;
        if (isset($_GET['location'])) {
            $location = $_GET['location'];
        }

        if ($location == 0) {
            $query->condition('fl.field_location_target_id', '1', '>=');
        } else if ($location == 1) {
            $query->condition('tfd.name', 'Dorcol', '=');
        } else if ($location == 2) {
            $query->condition('tfd.name', 'Banjica', '=');
        } else if ($location == 3) {
            $query->condition('tfd.name', 'Konjarnik', '=');
        } else if ($location == 4) {
            $query->condition('tfd.name', 'Liman', '=');
        } else if ($location == 5) {
            $query->condition('tfd.name', 'Detelinara', '=');
        } else if ($location == 6) {
            $query->condition('tfd.name', 'Grbavica', '=');
        }


        $query->innerJoin('node__field_property_image', 'fpi', 'n.nid = fpi.entity_id');
        $query->condition('fpi.delta', 0, '=');
        $query->innerJoin('file_managed', 'fm', 'fm.fid = fpi.field_property_image_target_id');
//        $query->innerJoin('node__field_address','nfa', 'nfa.entity_id = n.nid');

        $query->addField('tfd', 'name', 'address');
        $query->addField('nf', 'field_bathroom_value', 'bath');
        $query->addField('nfb', 'field_bedroom_value', 'bed');
        $query->addField('fp', 'field_price_value', 'price');
        $query->addField('fa', 'field_area_value', 'area');
        $query->addField('fm', 'uri', 'image');
        $query->addField('n', 'title', 't');
        $query->addField('n', 'nid', 'nid');

        $query = $query->extend( 'Drupal\Core\Database\Query\PagerSelectExtender' )->limit( 6 );
        $data = [];

        $results = $query->execute()->fetchAll();

        foreach ($results as $result) {
            $image=$result->image;
            $url = \Drupal\image\Entity\ImageStyle::load('featured_property_330x268')->buildUrl($image);
            $path =$result->nid;
            $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$path);

            $data[] = [
                'nid' => $alias,
                'image' => $url,
                'nas' => substr(strip_tags(str_replace(array("\r", "\n"), '', $result->t)), 0),
                'address' => $result->address,
                'bath' => $result->bath,
                'bed' => $result->bed,
                'price' => $result->price,
                'area' => $result->area,
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
        foreach ($form_state->getValues() as $key => $value) {
            drupal_set_message($key . ': ' . $value);
        }

    }
}