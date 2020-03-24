<?php

namespace Classes;

class Product {

    private $FPDO;
    protected $result = array(), $arr_category;

    public function __construct($fpdo) {
        try {
            $this->FPDO = $fpdo;
        } catch (Exception $ex) {
            error_log($ex->getMessage(), 3, "error.log");
        }
    }

    public function getProductInfo($product_id = 0) {
        try {
            $sqlquery = $this->FPDO
                    ->from('tblproducts')
                    ->where("tblproducts.id = :product_id AND tblproducts.status = :status", array(":product_id" => $product_id, ":status" => 707))
                    ->limit(1);
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        } catch (Exception $e) {
            echo "Exception while processing product: ", $e->getMessage(), "\n";
        }
    }

    /*  public function getProductByCategories($params = array()) {            
      $this->result = array();

      $sqlquery   =   "SELECT tblproducts.*, tblproduct_images.mini_image, tblproduct_images.thumb_image, tblproduct_images.medium_image, tblproduct_images.big_image, ";
      $sqlquery   =   $sqlquery . " tbltypes.type_name, tblfabrics.fabric_name, tblcolors.color_name";
      $sqlquery   =   $sqlquery . " FROM tblproducts";
      if(!empty($params['cat_subcat_ids'])) {
      $sqlquery = $sqlquery . " INNER JOIN (SELECT DISTINCT(product_id) AS product_id FROM tblproduct_categories WHERE tblproduct_categories.category_id IN (".$params['cat_subcat_ids'].")) AS tblcat_pro ON tblcat_pro.product_id = tblproducts.id";
      }
      $sqlquery   =   $sqlquery . " LEFT JOIN tbltypes ON tbltypes.id = tblproducts.type_id";
      $sqlquery   =   $sqlquery . " LEFT JOIN tblfabrics ON tblfabrics.id = tblproducts.fabric_id";
      $sqlquery   =   $sqlquery . " LEFT JOIN tblcolors ON tblcolors.id = tblproducts.color_id";
      $sqlquery   =   $sqlquery . " LEFT JOIN tblproduct_images ON tblproduct_images.product_id = tblproducts.id AND tblproduct_images.show_as_main = 1";

      $sqlquery   =   $sqlquery . " WHERE tblproducts.status = 707 ";

      if (!empty($params['sort']) && trim($params['sort']) == "ASC") {
      $sqlquery   =   $sqlquery . " ORDER BY tblproducts.net_price ASC";
      } elseif (!empty($params['sort']) && trim($params['sort']) == "DESC") {
      $sqlquery   =   $sqlquery . " ORDER BY tblproducts.net_price DESC";
      } else {
      $sqlquery   =   $sqlquery . " ORDER BY tblproducts.sort_order = 0, tblproducts.sort_order ASC, pro.saleprice ASC";
      }

      if(!empty($params['rowsPerPage'])) {
      $sqlquery   =   $sqlquery . " LIMIT ".$params['offset'].", ".$params['rowsPerPage']."";
      }

      $this->result = $this->FPDO->customResult($sqlquery)->fetchAll();
      return $this->result;
      } */

    public function getProductByCategories($params = array()) {
        $this->result = array();

        $sqlquery = "SELECT tblproducts.*, tblproduct_images.mini_image, tblproduct_images.thumb_image, tblproduct_images.medium_image, tblproduct_images.big_image ";

        $sqlquery = $sqlquery . " FROM tblproducts";
        if (!empty($params['cat_subcat_ids'])) {
            $sqlquery = $sqlquery . " INNER JOIN (SELECT DISTINCT(product_id) AS product_id FROM tblproduct_categories WHERE tblproduct_categories.category_id IN (" . $params['cat_subcat_ids'] . ")) AS tblcat_pro ON tblcat_pro.product_id = tblproducts.id";
        }
        $sqlquery = $sqlquery . " LEFT JOIN tblproduct_images ON tblproduct_images.product_id = tblproducts.id AND tblproduct_images.show_as_main = 1";

        $sqlquery = $sqlquery . " WHERE tblproducts.status = 707 ";

        if (!empty($params['sort']) && trim($params['sort']) == "ASC") {
            $sqlquery = $sqlquery . " ORDER BY tblproducts.net_price ASC";
        } elseif (!empty($params['sort']) && trim($params['sort']) == "DESC") {
            $sqlquery = $sqlquery . " ORDER BY tblproducts.net_price DESC";
        } else {
            $sqlquery = $sqlquery . " ORDER BY tblproducts.sort_order ASC";
        }

        if (!empty($params['rowsPerPage'])) {
            $sqlquery = $sqlquery . " LIMIT " . $params['offset'] . ", " . $params['rowsPerPage'] . "";
        }

        $this->result = $this->FPDO->customResult($sqlquery)->fetchAll();
        return $this->result;
    }

    public function getTotalProductByCategories($param = array()) {
        $this->result = array();

        $sqlquery = "SELECT COUNT(pro.id) AS total_products FROM ( ";
        $sqlquery = $sqlquery . "SELECT tblcategory.category_name, tblcategory.seo_url AS category_seo_url, tblproducts.*, tblproduct_deal_of_day.discount_rate AS deal_rate, tblmetal.metal_name, tblmetal_purity.metal_purity_name, ";

        $sqlquery = $sqlquery . " ROUND (( tblpro.gold_cost + tblpro.diamond_cost + tblpro.gemstone_cost + tblpro.labour_cost) * ( 1 + " . STORE_VAT . " / 100)) AS actualproductprice,";

        $sqlquery = $sqlquery . " (SELECT CASE WHEN (DATE( tblproduct_deal_of_day.deal_date ) = CURDATE()) ";
        $sqlquery = $sqlquery . "  THEN ( ";

        $sqlquery = $sqlquery . "  SELECT CASE WHEN (tblpro.diamond_cost > tblproducts.diamond_price_above ) ";
        $sqlquery = $sqlquery . "  THEN ( ";
        $sqlquery = $sqlquery . "  ROUND (( tblpro.gold_cost + (tblpro.diamond_cost * ( 1 - tblproducts.diamond_price_above / 100)) + tblpro.gemstone_cost + (tblpro.labour_cost * ( 1 - tblproducts.labour_discount_percent / 100))) * ( 1 + " . STORE_VAT . " / 100 ) * ( 1 - tblproduct_deal_of_day.discount_rate / 100)) ";
        $sqlquery = $sqlquery . " ) ELSE ( ";
        $sqlquery = $sqlquery . "  ROUND (( tblpro.gold_cost + tblpro.diamond_cost + tblpro.gemstone_cost + (tblpro.labour_cost * ( 1 - tblproducts.labour_discount_percent / 100))) * ( 1 + " . STORE_VAT . " / 100 ) * ( 1 - tblproduct_deal_of_day.discount_rate / 100)) ";
        $sqlquery = $sqlquery . " ) ";
        $sqlquery = $sqlquery . " END ";

        $sqlquery = $sqlquery . " ) ELSE ( ";
        $sqlquery = $sqlquery . "  SELECT CASE WHEN (tblpro.diamond_cost > tblproducts.diamond_price_above ) ";
        $sqlquery = $sqlquery . "  THEN ( ";
        $sqlquery = $sqlquery . "  ROUND (( tblpro.gold_cost + (tblpro.diamond_cost * ( 1 - tblproducts.diamond_price_above / 100)) + tblpro.gemstone_cost + (tblpro.labour_cost * ( 1 - tblproducts.labour_discount_percent / 100))) * ( 1 + " . STORE_VAT . " / 100 ) * ( 1 - tblproducts.discount_rate / 100)) ";
        $sqlquery = $sqlquery . " ) ELSE ( ";
        $sqlquery = $sqlquery . "  ROUND (( tblpro.gold_cost + tblpro.diamond_cost + tblpro.gemstone_cost + (tblpro.labour_cost * ( 1 - tblproducts.labour_discount_percent / 100))) * ( 1 + " . STORE_VAT . " / 100 ) * ( 1 - tblproducts.discount_rate / 100)) ";
        $sqlquery = $sqlquery . " ) ";
        $sqlquery = $sqlquery . " END ";
        $sqlquery = $sqlquery . " ) END AS saleprice ";

        $sqlquery = $sqlquery . " ) AS saleprice ";

        $sqlquery = $sqlquery . " FROM ( ";

        /*         * * This is the START of INNER Query *** */
        $sqlquery = $sqlquery . " SELECT tblproducts.id, ";

        //Gold Cost Calculation
        $sqlquery = $sqlquery . " ( SELECT COALESCE(SUM(tblpro1.approx_metal_weight * tblmetal_price.metal_price), 0) AS gold_cost FROM tblproducts AS tblpro1 ";
        if (!empty($param['metal_id'])) {
            $sqlquery = $sqlquery . " INNER JOIN tblmetal_price ON tblmetal_price.metal_id = " . $param['metal_id'] . " AND tblmetal_price.metal_purity_id = tblpro1.metal_purity_id ";
        } else {
            $sqlquery = $sqlquery . " INNER JOIN tblmetal_price ON tblmetal_price.metal_id = tblpro1.metal_id AND tblmetal_price.metal_purity_id = tblpro1.metal_purity_id ";
        }
        $sqlquery = $sqlquery . " WHERE tblpro1.id = tblproducts.id ";
        $sqlquery = $sqlquery . " ) AS gold_cost, ";

        //Diamond Cost Calculation
        $sqlquery = $sqlquery . " ( SELECT COALESCE(SUM( tblproduct_stone_detail.min_carat_weight * tblstone_price.stone_price ), 0) AS diamond_cost
            FROM tblproduct_stone_detail
            INNER JOIN tblstone_price ON tblstone_price.stone_id = tblproduct_stone_detail.stone_id
            AND tblstone_price.stone_size_id = tblproduct_stone_detail.stone_size_id
            AND tblstone_price.stone_clarity_id = tblproduct_stone_detail.stone_clarity_id
            WHERE tblproduct_stone_detail.product_id = tblproducts.id AND tblproduct_stone_detail.stone_id = 1
            ) AS diamond_cost,";

        //17.07.2014 Nidhi- Calculating Gemstone Cost according to its size X mincaratwt(i.e total carat weight)
        /* $sqlquery   =   $sqlquery . " ( SELECT COALESCE(SUM( min_carat_weight  * ".STORE_GEMSTONE." ), 0) AS gemstone_cost
          FROM tblproduct_stone_detail
          WHERE tblproduct_stone_detail.product_id = tblproducts.id
          AND tblproduct_stone_detail.stone_id !=1
          ) AS gemstone_cost, "; */

        //Gemstone Cost Calculation
        $sqlquery = $sqlquery . " ( SELECT COALESCE(SUM(tblproduct_stone_detail.min_carat_weight * tblstone_price.stone_price), 0) AS gemstone_cost
            FROM tblproduct_stone_detail
            INNER JOIN tblstone_price ON tblstone_price.stone_id = tblproduct_stone_detail.stone_id
            AND tblstone_price.stone_size_id = tblproduct_stone_detail.stone_size_id
            AND tblstone_price.stone_clarity_id = tblproduct_stone_detail.stone_clarity_id
            WHERE tblproduct_stone_detail.product_id = tblproducts.id AND tblproduct_stone_detail.stone_id != 1
            ) AS gemstone_cost, ";

        //Labour Cost Calculation
        $sqlquery = $sqlquery . " ( SELECT COALESCE(SUM(tblpro2.labour_cost * tblpro2.approx_metal_weight), 0) AS labour_cost
            FROM tblproducts AS tblpro2                                            
            WHERE tblpro2.id = tblproducts.id
            ) AS labour_cost ";

        $sqlquery = $sqlquery . " FROM tblproducts) AS tblpro ";

        /*         * * This is the END of INNER Query *** */

        $sqlquery = $sqlquery . " INNER JOIN tblproducts ON tblproducts.id = tblpro.id ";

        $sqlquery = $sqlquery . " LEFT OUTER JOIN tblproduct_deal_of_day ON tblproduct_deal_of_day.product_id = tblproducts.id ";

        $sqlquery = $sqlquery . " LEFT OUTER JOIN tblcategory ON tblcategory.id = tblproducts.category_id ";

        $sqlquery = $sqlquery . " INNER JOIN tblmetal ON tblmetal.id = tblproducts.metal_id ";

        $sqlquery = $sqlquery . " INNER JOIN tblmetal_purity ON tblmetal_purity.id = tblproducts.metal_purity_id ";

        //Join According To Category
        if (!empty($param['cat_id'])) {
            $sqlquery = $sqlquery . " INNER JOIN ( SELECT DISTINCT(product_id) AS product_id FROM tblproduct_categories WHERE tblproduct_categories.category_id IN (" . $param['cat_subcat_ids'] . ") ) AS tblcat_pro ON tblcat_pro.product_id = tblproducts.id";
        }

        //Join According To Tag
        if (!empty($param['tag_id'])) {
            $sqlquery = $sqlquery . " INNER JOIN ( SELECT DISTINCT(product_id) AS product_id FROM tblproduct_tags WHERE tblproduct_tags.tag_id = " . $param['tag_id'] . " ) AS tbltag_pro ON tbltag_pro.product_id = tblproducts.id";
        }

        //Join According To Stone
        if (!empty($param['stone_id'])) {
            $sqlquery = $sqlquery . " INNER JOIN ( SELECT DISTINCT(product_id) AS product_id FROM tblproduct_stone_detail WHERE tblproduct_stone_detail.stone_id = " . $param['stone_id'] . " ) AS tblstone_pro ON tblstone_pro.product_id = tblproducts.id";
        }

        //Join According To Stone Shape
        if (!empty($param['stone_shape_id'])) {
            $sqlquery = $sqlquery . " INNER JOIN ( SELECT DISTINCT(product_id) AS product_id FROM tblproduct_stone_detail WHERE tblproduct_stone_detail.stone_shape_id = " . $param['stone_shape_id'] . " ) AS tblstone_shape_pro ON tblstone_shape_pro.product_id = tblproducts.id";
        }

        //Join According To Design and Gender
        if (!empty($param['design_id']) && !empty($param['gender_id'])) {
            $sqlquery = $sqlquery . " INNER JOIN ( SELECT DISTINCT(product_id) AS product_id FROM tblproduct_options WHERE tblproduct_options.option_value_id IN ( " . $param['design_id'] . ", " . $param['gender_id'] . " )) AS tbloption_value_pro ON tbloption_value_pro.product_id = tblproducts.id";
            //$sqlquery  = $sqlquery . " AND tblproducts.id IN (SELECT DISTINCT product_id  FROM tblproduct_options WHERE tblproduct_options.option_value_id IN (".$design_id. ",".$gender_id.") GROUP BY product_id HAVING count( DISTINCT option_value_id ) =2)";
        } elseif (!empty($param['design_id']) && empty($param['gender_id'])) {
            $sqlquery = $sqlquery . " INNER JOIN ( SELECT DISTINCT(product_id) AS product_id FROM tblproduct_options WHERE tblproduct_options.option_value_id IN ( " . $param['design_id'] . " )) AS tbloption_value_pro ON tbloption_value_pro.product_id = tblproducts.id";
            //$sqlquery  = $sqlquery . " AND tblproducts.id IN (SELECT DISTINCT product_id  FROM tblproduct_options WHERE tblproduct_options.option_value_id IN (".$design_id.") GROUP BY product_id )";
        } elseif (empty($param['design_id']) && !empty($param['gender_id'])) {
            $sqlquery = $sqlquery . " INNER JOIN ( SELECT DISTINCT(product_id) AS product_id FROM tblproduct_options WHERE tblproduct_options.option_value_id IN ( " . $param['gender_id'] . " )) AS tbloption_value_pro ON tbloption_value_pro.product_id = tblproducts.id";
            //$sqlquery  = $sqlquery . " AND tblproducts.id IN (SELECT DISTINCT product_id  FROM tblproduct_options WHERE tblproduct_options.option_value_id IN (".$gender_id.") GROUP BY product_id )";
        }

        //Join According To No of Stones
        if (!empty($param['no_of_stones'])) {
            if ((int) $param['no_of_stones'] == 1) {
                $sqlquery = $sqlquery . " INNER JOIN (SELECT product_id FROM (SELECT DISTINCT product_id , SUM(stone_quantity) AS no_of_stones FROM tblproduct_stone_detail GROUP BY product_id) AS sumpro WHERE sumpro.no_of_stones = 1) AS tbltot_stone_pro ON tbltot_stone_pro.product_id = tblproducts.id";
            } elseif ((int) $param['no_of_stones'] == 3) {
                $sqlquery = $sqlquery . " INNER JOIN (SELECT product_id FROM (SELECT DISTINCT product_id , SUM(stone_quantity) AS no_of_stones FROM tblproduct_stone_detail GROUP BY product_id) AS sumpro WHERE sumpro.no_of_stones = 3) AS tbltot_stone_pro ON tbltot_stone_pro.product_id = tblproducts.id";
            } elseif ((int) $param['no_of_stones'] == 5) {
                $sqlquery = $sqlquery . " INNER JOIN (SELECT product_id FROM (SELECT DISTINCT product_id , SUM(stone_quantity) AS no_of_stones FROM tblproduct_stone_detail GROUP BY product_id) AS sumpro WHERE sumpro.no_of_stones = 5) AS tbltot_stone_pro ON tbltot_stone_pro.product_id = tblproducts.id";
            } elseif ((int) $param['no_of_stones'] == 6) {
                $sqlquery = $sqlquery . " INNER JOIN (SELECT product_id FROM (SELECT DISTINCT product_id , SUM(stone_quantity) AS no_of_stones FROM tblproduct_stone_detail GROUP BY product_id) AS sumpro WHERE sumpro.no_of_stones > 5) AS tbltot_stone_pro ON tbltot_stone_pro.product_id = tblproducts.id";
            }
        }

        ///Mount Stone Shape and Stone Size
        if (!empty($param['mount_stone_id']) && !empty($param['mount_stone_shape_id']) && !empty($param['mount_stone_size'])) {
            $sqlquery = $sqlquery . " INNER JOIN (SELECT DISTINCT(product_id) AS product_id FROM tblproduct_mould_detail WHERE tblproduct_mould_detail.stone_id = " . $param['mount_stone_id'] . " AND tblproduct_mould_detail.stone_shape_id = " . $param['mount_stone_shape_id'] . " AND tblproduct_mould_detail.stone_size_from <= " . $param['mount_stone_size'] . " AND tblproduct_mould_detail.stone_size_to >= " . $param['mount_stone_size'] . ") AS tblproduct_mould ON tblproduct_mould.product_id = tblproducts.id";
        } elseif (!empty($param['mount_stone_id']) && !empty($param['mount_stone_shape_id'])) {
            $sqlquery = $sqlquery . " INNER JOIN (SELECT DISTINCT(product_id) AS product_id FROM tblproduct_mould_detail WHERE tblproduct_mould_detail.stone_id = " . $param['mount_stone_id'] . " AND tblproduct_mould_detail.stone_shape_id = " . $param['mount_stone_shape_id'] . ") AS tblproduct_mould ON tblproduct_mould.product_id = tblproducts.id";
        }

        $sqlquery = $sqlquery . " WHERE tblproducts.status = 707 ";

        if (!empty($param['is_mould'])) {
            $sqlquery = $sqlquery . " AND tblproducts.is_mould = " . (int) $param['is_mould'] . "";
        }

        //if(!empty($param['metal_id']) && (int)$param['metal_id'] == 1 && !empty($param['is_filter']) && (int)$param['is_filter'] == 1) {
        if (!empty($param['metal_id']) && (int) $param['metal_id'] == 1) {
            $sqlquery = $sqlquery . " AND tblproducts.metal_id = " . $param['metal_id'] . "";
        } elseif (!empty($param['metal_id']) && (int) $param['metal_id'] == 2) {
            $sqlquery = $sqlquery . " AND tblproducts.is_white_gold = 1";
        }

        if (!empty($param['keyword'])) {
            $sqlquery = $sqlquery . " AND (tblproducts.sku LIKE '%" . $param['keyword'] . "%' OR tblproducts.product_name LIKE '%" . $param['keyword'] . "%' OR tblproducts.tags LIKE '%" . $param['keyword'] . "%')";
        }

        $sqlquery = $sqlquery . ") AS pro";

        if (!empty($param['price_from']) && !empty($param['price_to'])) {
            //$sqlquery = $sqlquery . " WHERE pro.saleprice BETWEEN ROUND(10001/".$_SESSION['goldnstonelane_currency_value'].") AND ROUND(20000/".$_SESSION['goldnstonelane_currency_value'].") ";
            $sqlquery = $sqlquery . " WHERE pro.saleprice BETWEEN ROUND(" . $param['price_from'] . ") AND ROUND(" . $param['price_to'] . ") ";
        }

        /*
          if (!empty($price_id)) {
          if((int)$price_id==0){
          $sqlquery = $sqlquery . " WHERE pro.saleprice IS NOT NULL";
          } elseif((int)$price_id==1) {
          $sqlquery = $sqlquery . " WHERE pro.saleprice < ROUND(10000/".$_SESSION['goldnstonelane_currency_value'].")";
          } else if((int)$price_id==2) {
          $sqlquery = $sqlquery . " WHERE pro.saleprice BETWEEN ROUND(10001/".$_SESSION['goldnstonelane_currency_value'].") AND ROUND(20000/".$_SESSION['goldnstonelane_currency_value'].") ";
          } else if((int)$price_id==3) {
          $sqlquery = $sqlquery . " WHERE pro.saleprice BETWEEN ROUND(20001/".$_SESSION['goldnstonelane_currency_value'].") AND ROUND(30000/".$_SESSION['goldnstonelane_currency_value'].") ";
          } else if((int)$price_id==4) {
          $sqlquery = $sqlquery . " WHERE pro.saleprice BETWEEN ROUND(30001/".$_SESSION['goldnstonelane_currency_value'].") AND ROUND(50000/".$_SESSION['goldnstonelane_currency_value'].") ";
          } else if((int)$price_id==5) {
          $sqlquery = $sqlquery . " WHERE pro.saleprice BETWEEN ROUND(50001/".$_SESSION['goldnstonelane_currency_value'].") AND ROUND(100000/".$_SESSION['goldnstonelane_currency_value'].") ";
          } else if((int)$price_id==6) {
          $sqlquery = $sqlquery . " WHERE pro.saleprice >= ROUND(1000001/".$_SESSION['goldnstonelane_currency_value'].")";
          }
          }
         */

        if (!empty($param['sort']) && trim($param['sort']) == "ASC") {
            $sqlquery = $sqlquery . " ORDER BY pro.saleprice ASC";
        } elseif (!empty($sort) && trim($sort) == "DESC") {
            $sqlquery = $sqlquery . " ORDER BY pro.saleprice DESC";
        } else {
            $sqlquery = $sqlquery . " ORDER BY pro.sort_order = 0, pro.sort_order ASC, pro.saleprice ASC";
        }
        /*
          if(!empty($param['rowsPerPage'])) {
          $sqlquery   =   $sqlquery . " LIMIT ".$param['offset'].", ".$param['rowsPerPage']."";
          }
         */
        $this->result = $this->FPDO->customResult($sqlquery)->fetchAll();

        return $this->result;
    }

    public function isProduct($seo_url = null) {
        if (!empty($seo_url)) {
            $sqlquery = $this->FPDO->from('tblproducts')
                    ->select(null)
                    ->select('tblproducts.id')
                    ->where("tblproducts.seo_url = :seo_url AND tblproducts.status = :status", array(":seo_url" => $seo_url, ":status" => 707));
            $rsproducts = $sqlquery->fetchAll();
            if (count($rsproducts) > 0) {
                foreach ($rsproducts as $rowproduct) {
                    $this->result['id'] = $rowproduct['id'];
                    return $this->result['id'];
                }
            }
        }

        return false;
    }

    public function getProductTags($product_id = 0) {
        $this->result = array();
        $sqlquery = $this->FPDO->from('tbltags')
                ->select(null)
                ->select('tbltags.id, tbltags.tag_name, tbltags.seo_url ')
                ->innerJoin('tblproduct_tags ON tblproduct_tags.tag_id = tbltags.id')
                ->where("tblproduct_tags.product_id = :product_id", array(":product_id" => $product_id));
        $this->result = $sqlquery->fetchAll();

        return $this->result;
    }

    public function getProductCategories($product_id = 0) {
        $this->result = array();
        $sqlquery = $this->FPDO->from('tblproduct_categories')
                ->select(null)
                ->select('tblproduct_categories.category_id, tblcategories.category_name')
                ->innerJoin('tblcategories ON tblcategories.id = tblproduct_categories.category_id')
                ->where("tblproduct_categories.product_id = :product_id AND tblcategories.status = :status", array(":product_id" => $product_id, ":status" => 707));
        $this->result = $sqlquery->fetchAll();
        return $this->result;
    }

    public function getProductImages($product_id = 0) {
        $this->result = array();
        $sqlquery = $this->FPDO->from('tblproduct_images')
                ->select(null)
                ->select('tblproduct_images.product_id, tblproduct_images.big_image,tblproduct_images.medium_image,tblproduct_images.thumb_image,tblproduct_images.alt_text')
                ->where("tblproduct_images.product_id = :product_id AND tblproduct_images.is_featured = 0 AND tblproduct_images.show_as_main = 0 AND tblproduct_images.is_banner = 0", array(":product_id" => $product_id));
        $this->result = $sqlquery->fetchAll();

        return $this->result;
    }

    public function getProductMainImage($product_id = 0) {
        $this->result = array();
        $sqlquery = $this->FPDO->from('tblproduct_images')
                ->select(null)
                ->select('tblproduct_images.product_id, tblproduct_images.big_image,tblproduct_images.medium_image')
                ->where("tblproduct_images.product_id = :product_id AND tblproduct_images.show_as_main = :show_as_main ", array(":product_id" => $product_id, ":show_as_main" => 1));
        $this->result = $sqlquery->fetchAll();

        return $this->result;
    }

    public function getProductDetail($params = array()) {
        try {
            $sqlquery = $this->FPDO
                    ->from('tblproducts')
                    ->select(null)
                    ->select('tblproducts.*')
                    ->select('GROUP_CONCAT(tblproduct_categories.category_id) AS category_ids')
                    ->select('tblproduct_images.thumb_image, tblproduct_images.medium_image')
                    ->leftJoin('tblproduct_categories ON tblproduct_categories.product_id = tblproducts.id')
                    ->leftJoin('tblproduct_images ON tblproduct_images.product_id = tblproducts.id AND tblproduct_images.show_as_main = 1')
                    ->where("tblproducts.id = :product_id AND tblproducts.status = :status", array(":product_id" => $params['product_id'], ":status" => 707))
                    ->group('tblproduct_categories.product_id')
                    ->limit(1);
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        } catch (Exception $e) {
            echo "Exception while processing product: ", $e->getMessage(), "\n";
        }
    }

    public function getCategoryProductDetail($params = array()) {
        try {
            $sqlquery = $this->FPDO
                    ->from('tblproducts')
                    ->select(null)
                    ->select('tblproducts.*')
                    ->select('GROUP_CONCAT(tblproduct_categories.category_id) AS category_ids')
                    ->select('tblproduct_images.thumb_image, tblproduct_images.medium_image')
                    ->leftJoin('tblproduct_categories ON tblproduct_categories.product_id = tblproducts.id')
                    ->leftJoin('tblproduct_images ON tblproduct_images.product_id = tblproducts.id AND tblproduct_images.show_as_main = 1')
                    ->where("tblproduct_categories.category_id = :category_id AND tblproducts.status = :status", array(":category_id" => $params['category_id'], ":status" => 707))
                    ->group('tblproduct_categories.product_id')
                    ->order('tblproducts.sort_order ASC');
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        } catch (Exception $e) {
            echo "Exception while processing product: ", $e->getMessage(), "\n";
        }
    }

    /*
      public function getProductByFilters($params = array()) {
      $this->result = array();

      try {

      $sqlquery   =  "SELECT tblproducts.*, tblproduct_images.mini_image, tblproduct_images.thumb_image, tblproduct_images.medium_image, tblproduct_images.big_image FROM tblproducts";

      if(!empty($params['cat_subcat_ids'])) {
      $sqlquery = $sqlquery . " INNER JOIN (SELECT DISTINCT(product_id) AS product_id FROM tblproduct_categories WHERE tblproduct_categories.category_id IN (".$params['cat_subcat_ids'].")) AS tblcat_pro ON tblcat_pro.product_id = tblproducts.id";
      }
      $sqlquery   =   $sqlquery . " LEFT JOIN tblproduct_images ON tblproduct_images.product_id = tblproducts.id AND tblproduct_images.show_as_main = 1";

      if (!empty($params['sort']) && trim($params['sort']) == "ASC") {
      $sqlquery   =   $sqlquery . " ORDER BY tblproducts.net_price ASC";
      } elseif (!empty($params['sort']) && trim($params['sort']) == "DESC") {
      $sqlquery   =   $sqlquery . " ORDER BY tblproducts.net_price DESC";
      } else {
      $sqlquery   =   $sqlquery . " ORDER BY tblproducts.sort_order = 0, tblproducts.sort_order ASC, pro.saleprice ASC";
      }

      if(!empty($params['rowsPerPage'])) {
      $sqlquery   =   $sqlquery . " LIMIT ".$params['offset'].", ".$params['rowsPerPage']."";
      }

      $sqlquery = $sqlquery . " SELECT DISTINCT(product_id) ";

      $sqlquery = $sqlquery . " SELECT DISTINCT(product_id) AS product_id FROM tblproduct_types WHERE tblproduct_types.type_id IN (".$params['type_ids'].")";

      $sqlquery = $sqlquery . " UNION";
      $sqlquery = $sqlquery . " SELECT DISTINCT(product_id) AS product_id FROM tblproduct_stories WHERE tblproduct_stories.story_id IN (".$params['story_ids'].")";

      $sqlquery = $sqlquery . " UNION";
      $sqlquery = $sqlquery . " SELECT DISTINCT(product_id) AS product_id FROM tblproduct_fabrics WHERE tblproduct_fabrics.fabric_id IN (".$params['fabric_ids'].")";

      $sqlquery = $sqlquery . " UNION";
      $sqlquery = $sqlquery . " SELECT DISTINCT(product_id) AS product_id FROM tblproduct_colors WHERE tblproduct_colors.color_id IN (".$params['color_ids'].")";

      $sqlquery = $sqlquery . " UNION";
      $sqlquery = $sqlquery . " SELECT DISTINCT(product_id) AS product_id FROM tblproduct_variants WHERE tblproduct_variants.size_id IN (".$params['size_ids'].")";

      $sqlquery = "SELECT ";


      $this->result = $this->FPDO->customResult($sqlquery)->fetchAll();
      return $this->result;

      } catch (Exception $e) {
      echo "Exception while processing product: ", $e->getMessage(), "\n";
      }
      }
     */

    public function getProductByFilters($params = array()) {
        $this->result = array();

        $sqlquery = "SELECT tblproducts.*, tblproduct_images.mini_image, tblproduct_images.thumb_image, tblproduct_images.medium_image, tblproduct_images.big_image, ";
        $sqlquery = $sqlquery . " tbltypes.type_name, tblfabrics.fabric_name, tblcolors.color_name";
        $sqlquery = $sqlquery . " FROM tblproducts";
        if (!empty($params['category_ids'])) {
            $sqlquery = $sqlquery . " INNER JOIN (SELECT DISTINCT(product_id) AS product_id FROM tblproduct_categories WHERE tblproduct_categories.category_id IN (" . $params['category_ids'] . ")) AS tblcat_pro ON tblcat_pro.product_id = tblproducts.id";
        }
        $sqlquery = $sqlquery . " LEFT JOIN tbltypes ON tbltypes.id = tblproducts.type_id";
        $sqlquery = $sqlquery . " LEFT JOIN tblfabrics ON tblfabrics.id = tblproducts.fabric_id";
        $sqlquery = $sqlquery . " LEFT JOIN tblcolors ON tblcolors.id = tblproducts.color_id";
        $sqlquery = $sqlquery . " LEFT JOIN tblproduct_images ON tblproduct_images.product_id = tblproducts.id AND tblproduct_images.show_as_main = 1";

        $sqlquery = $sqlquery . " WHERE tblproducts.id != 0";
        if (!empty($params['type_ids'])) {
            $sqlquery = $sqlquery . " AND tblproducts.type_id IN (" . $params['type_ids'] . ")";
        }
        if (!empty($params['fabric_ids'])) {
            $sqlquery = $sqlquery . " AND tblproducts.fabric_id IN (" . $params['fabric_ids'] . ")";
        }
        if (!empty($params['color_ids'])) {
            $sqlquery = $sqlquery . " AND tblproducts.color_id IN (" . $params['color_ids'] . ")";
        }
        if (!empty($params['size_ids'])) {
            $sqlquery = $sqlquery . " AND tblproducts.id IN (SELECT DISTINCT(tblproduct_variants.product_id) AS product_id FROM tblproduct_variants WHERE tblproduct_variants.size_id IN (" . $params['size_ids'] . ") AND tblproduct_variants.quantity > 0)";
        }
        if (!empty($params['keyword'])) {
            $sqlquery = $sqlquery . " AND (tblproducts.product_name LIKE '%" . $params['keyword'] . "%' OR tblproducts.sku LIKE '%" . $params['keyword'] . "%' OR tblproducts.description LIKE '%" . $params['keyword'] . "%')";
        }
        if (!empty($params['sort']) && trim($params['sort']) == "ASC") {
            $sqlquery = $sqlquery . " ORDER BY tblproducts.net_price ASC";
        } elseif (!empty($params['sort']) && trim($params['sort']) == "DESC") {
            $sqlquery = $sqlquery . " ORDER BY tblproducts.net_price DESC";
        } else {
            $sqlquery = $sqlquery . " ORDER BY tblproducts.sort_order ASC";
        }

        if (!empty($params['rowsPerPage'])) {
            $sqlquery = $sqlquery . " LIMIT " . $params['offset'] . ", " . $params['rowsPerPage'] . "";
        }

        $this->result = $this->FPDO->customResult($sqlquery)->fetchAll();
        return $this->result;
    }

    public function getProductTechSpec($product_id = 0) {
        $this->result = array();
        $sqlquery = $this->FPDO->from('tblproduct_tech_spec')
                ->where('product_id = ? AND status = ?', $product_id, 707)
                ->order('sort_order = 0,sort_order ASC');
        $this->result = $sqlquery->fetchAll();

        return $this->result;
    }

    public function getProductBannerImage($product_id = 0) {
        $this->result = array();
        $sqlquery = $this->FPDO->from('tblproduct_images')
                ->select(null)
                ->select('tblproduct_images.product_id, tblproduct_images.big_image,tblproduct_images.medium_image,tblproduct_images.thumb_image')
                ->where("tblproduct_images.product_id = :product_id AND tblproduct_images.is_banner = :is_banner", array(":product_id" => $product_id, ":is_banner" => 1));
        $this->result = $sqlquery->fetchAll();

        return $this->result;
    }

    public function getProductFeaturedImage($product_id = 0) {
        $this->result = array();
        $sqlquery = $this->FPDO->from('tblproduct_images')
                ->select(null)
                ->select('tblproduct_images.product_id, tblproduct_images.big_image,tblproduct_images.medium_image,tblproduct_images.thumb_image,tblproduct_images.alt_text')
                ->where("tblproduct_images.product_id = :product_id AND tblproduct_images.is_featured = :is_featured", array(":product_id" => $product_id, ":is_featured" => 1));
        $this->result = $sqlquery->fetchAll();

        return $this->result;
    }
    
    
    public function getSearchProducts($params = array()) {
            try {
                $sqlquery = $this->FPDO
                                 ->from('tblproducts')
                                 ->select(null)
                                 ->select('tblproducts.id, tblproducts.product_name, tblproducts.product_name, tblproducts.seo_url')
                                 ->where("tblproducts.status = :status", array(":status" => 707))
                                 ->order('tblproducts.sort_order ASC')
                                 ->limit(100)
                        ;   
                if($params['keyword'] !=''){            
                        $keyword = $params['keyword'];
                        $sqlquery ->where("tblproducts.product_name  LIKE  '%$keyword%'");
                }
                $this->result = $sqlquery->fetchAll();
               // echo '<pre>';
               // print_r($this->result);exit;
                return $this->result;
            } catch (Exception $e) {
                echo "Exception while processing product: ", $e->getMessage(), "\n";
            }    
        }
        
        
        // by Dinesh
        
        public function getNewProductInfo() {
            try {
                $sqlquery = $this->FPDO
                        ->from('tblproducts')
                        ->where("tblproducts.status = :status AND tblproducts.is_new = :is_new", array(":status" => 707, ":is_new"=>1))
                        ->order('tblproducts.id DESC')
                        ->limit(1);
                $this->result = $sqlquery->fetch();
                
                return $this->result;
            } catch (Exception $e) {
                echo "Exception while processing product: ", $e->getMessage(), "\n";
            }
        }

}

?>