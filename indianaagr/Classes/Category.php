<?php

namespace Classes;

class Category {

    private $FPDO;
    private $result = array(), $arr_cat = array(), $arr_breadcrumb = array();

    public function __construct($fpdo) {
        try {
            $this->FPDO = $fpdo;
        } catch (Exception $ex) {
            error_log($ex->getMessage(), 3, "error.log");
        }
    }

    public function getCategoryIds($cat_id = 0) {
        $this->arr_cat[] = $cat_id;

        $sqlquery = $this->FPDO->from('tblcategories')
                ->select(null)
                ->select('tblcategories.id')
                ->where("tblcategories.parent_id = :parent_id AND tblcategories.status = :status", array(":parent_id" => $cat_id, ":status" => 707));
        $rscategory = $sqlquery->fetchAll();
        if (count($rscategory) > 0) {
            foreach ($rscategory as $rowcategory) {
                $this->arr_cat[] = $rowcategory['id'];
                $this->getCategoryIds($rowcategory['id']);
            }
        }
        asort($this->arr_cat);
        $this->result = array_unique($this->arr_cat);
        return $this->result;
    }

    public function getCategoryInfo($cat_id = 0) {
        try {
            $sqlquery = $this->FPDO
                    ->from('tblcategories')
                    ->where("tblcategories.id = :cat_id AND tblcategories.status = :status", array(":cat_id" => $cat_id, ":status" => 707))
                    ->limit(1);
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        } catch (Exception $e) {
            echo "Exception while processing category: ", $e->getMessage(), "\n";
        }
    }

    public function getParentCategories() {

        $sqlquery = $this->FPDO->from('tblcategories')
                ->select(null)
                ->select('tblcategories.id, tblcategories.category_name, tblcategories.category_logo, tblcategories.seo_url, tblcategories.thumb_image, tblcategories.medium_image')
                ->where("tblcategories.parent_id = :parent_id AND tblcategories.status = :status", array(":parent_id" => 0, ":status" => 707))
                ->order('tblcategories.sort_order = 0, tblcategories.sort_order ASC');
        $this->result = $sqlquery->fetchAll();
        return $this->result;
    }

    public function getChildCategories($parent_id = 0) {

        $sqlquery = $this->FPDO->from('tblcategories')
                ->select(null)
                ->select('tblcategories.id, tblcategories.category_name, tblcategories.seo_url, tblcategories.thumb_image, tblcategories.medium_image, tblcategories.sort_order')
                ->where("tblcategories.parent_id = :parent_id AND tblcategories.status = :status", array(":parent_id" => $parent_id, ":status" => 707))
                ->order('tblcategories.sort_order ASC');
        //->order('tblcategories.category_name ASC');
        $this->result = $sqlquery->fetchAll();
        return $this->result;
    }

    public function isChildCategory($parent_id = 0) {

        $sqlquery = $this->FPDO->from('tblcategories')
                ->select(null)
                ->select('tblcategories.id,tblcategories.seo_url')
                ->where("tblcategories.parent_id = :parent_id AND tblcategories.status = :status", array(":parent_id" => $parent_id, ":status" => 707))
                ->order('tblcategories.sort_order = 0, tblcategories.sort_order ASC')
                ->limit(1);
        //->order('tblcategories.category_name ASC');
        $this->result = $sqlquery->fetchAll();
        return $this->result;
    }

    public function getMenuChildCategories($parent_id = 0) {

        $sqlquery = $this->FPDO->from('tblcategories')
                ->select(null)
                ->select('tblcategories.id, tblcategories.category_name, tblcategories.seo_url, tblcategories.thumb_image, tblcategories.medium_image')
                ->where("tblcategories.parent_id = :parent_id AND tblcategories.status = :status", array(":parent_id" => $parent_id, ":status" => 707))
                //->order('tblcategories.sort_order = 0, tblcategories.sort_order ASC');
                ->order('tblcategories.category_name ASC');
        $this->result = $sqlquery->fetchAll();
        return $this->result;
    }

    public function getAllMenuCategories() {
        $this->result = array();
        $sqlquery = $this->FPDO->from('tblcategories')
                ->select(null)
                ->select('tblcategories.id, tblcategories.category_name, tblcategories.seo_url, tblcategories.thumb_image, tblcategories.parent_id')
                ->where("tblcategories.status = :status", array(":status" => 707))
                ->order('tblcategories.sort_order = 0, tblcategories.sort_order ASC');
        $rscategories = $sqlquery->fetchAll();
        if (count($rscategories) > 0) {
            foreach ($rscategories as $rowcategory) {
                $this->result[$rowcategory['parent_id']][] = $rowcategory;
            }
        }

        return $this->result;
    }

    public function isCategory($seo_url = null) {
        if (!empty($seo_url)) {
            $sqlquery = $this->FPDO->from('tblcategories')
                    ->select(null)
                    ->select('tblcategories.id')
                    ->where("tblcategories.seo_url = :seo_url AND tblcategories.status = :status", array(":seo_url" => $seo_url, ":status" => 707));
            $categories = $sqlquery->fetchAll();
            if (count($categories) > 0) {
                foreach ($categories as $category) {
                    $this->result['id'] = $category['id'];
                    return $this->result['id'];
                }
            }
        }

        return false;
    }

    public function getBreadcrumbs($cat_id = 0) {
        $this->result = array();
        $sqlquery = $this->FPDO->from('tblcategories')
                ->select(null)
                ->select('tblcategories.id, tblcategories.category_name, tblcategories.seo_url, tblcategories.parent_id')
                ->where("tblcategories.id = :id AND tblcategories.status = :status", array(":id" => $cat_id, ":status" => 707))
                ->limit(1);
        $rscategory = $sqlquery->fetchAll();
        if (count($rscategory) > 0) {
            foreach ($rscategory as $rowcategory) {
                array_push($this->arr_breadcrumb, $rowcategory);
                $this->getBreadcrumbs($rowcategory['parent_id']);
            }
        } else {
            return false;
        }

        $this->result = array_reverse($this->arr_breadcrumb);
        return $this->result;
    }

    public function getRootCategoryId($cat_id = 0) {
        $this->result['id'] = 0;
        $sqlquery = $this->FPDO->from('tblcategories')
                ->select(null)
                ->select('tblcategories.id, tblcategories.parent_id')
                ->where("tblcategories.id = :id AND tblcategories.status = :status", array(":id" => $cat_id, ":status" => 707));
        $rscategories = $sqlquery->fetchAll();
        if (count($rscategories) > 0) {
            foreach ($rscategories as $rowcategory) {
                if ((int) $rowcategory['parent_id'] == 0) {
                    $this->result['id'] = $rowcategory['id'];
                    return $this->result['id'];
                } else {
                    return $this->getRootCategoryId($rowcategory['parent_id']);
                }
            }
        }
    }

    public function getCategoryShow() {
        $sqlquery = $this->FPDO->from('tblcategories')
                ->select(null)
                ->select('tblcategories.id, tblcategories.category_name, tblcategories.seo_url, tblcategories.thumb_image, tblcategories.medium_image')
                ->where("tblcategories.show_home = :show_home AND tblcategories.status = :status", array(":show_home" => 1, ":status" => 707))
                //->order('tblcategories.sort_order = 0, tblcategories.sort_order ASC');
                ->order('tblcategories.sort_order ASC');
        $this->result = $sqlquery->fetchAll();
        return $this->result;
    }

    public function getPhotoCategory() {

        $sqlquery = $this->FPDO->from('tblphoto_categories')
                ->select(null)
                ->select('tblphoto_categories.*')
                ->where("tblphoto_categories.parent_id = :parent_id AND tblphoto_categories.status = :status", array(":parent_id" => 0, ":status" => 707))
                ->order('tblphoto_categories.sort_order ASC');
        $this->result = $sqlquery->fetchAll();
        return $this->result;
    }
    
    public function getCategoryPhoto($photo_category_id) {
        $sqlquery = $this->FPDO->from('tblphotos')
                ->select(null)
                ->select('tblphotos.*')
                ->where("tblphotos.photo_category_id = :photo_category_id AND tblphotos.status = :status", array(":photo_category_id" => $photo_category_id, ":status" => 707))
                ->order('tblphotos.sort_order ASC');
        $this->result = $sqlquery->fetchAll();
        return $this->result;
    }
    
    public function isCategoryPhoto($seo_url = null) {
        if (!empty($seo_url)) {
            $sqlquery = $this->FPDO->from('tblphoto_categories')
                    ->select(null)
                    ->select('tblphoto_categories.*')
                    ->where("tblphoto_categories.seo_url = :seo_url AND tblphoto_categories.status = :status", array(":seo_url" => $seo_url, ":status" => 707));
            $categories = $sqlquery->fetch();
            if (!empty($categories)) {
                    return $categories;
            }
        }

        return false;
    }

}

?>