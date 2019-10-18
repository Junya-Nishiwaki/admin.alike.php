<?php

/**
 * Utilヘルパー
 * @package       app.View.Helper
 */
class UtilHelper extends AppHelper {
    
    /**
     * 検索文字ハイライト
     * @return string
     */
    public function matchWordHightlight($words_, $subject_) {
        if (!empty($words_)) {
            return preg_replace('/(' . $words_ . ')/', '<strong style="background-color: #99FF66;">$1</strong>', $subject_);
        }
        return $subject_;
    }
}
