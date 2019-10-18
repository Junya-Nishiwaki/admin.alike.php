<?php
/**
 * モデルクラス用ログ
 * 
 * @package Model
 */
class ModelLog {
    // ログファイルディレクトリ
    const LOGDIR = '/var/www/log/';
    const LOGFILE_NAME = 'admin_model.log';
    // ログファイルローテーションのしきい値
    const FILESIZE_LIMIT = 524288000;

    /**
     * アプリケーションログ(DEBUG)
     *
     * @param string $log_ 出力する内容
     * @return なし
     */
    public static function output_log_D($log_) {
        if (preg_match('/D/', OUTPUT_LOG_LEVEL)) {
            self::output_log(self::LOGFILE_NAME, 'D', $log_);
        }
    }

    /**
     * アプリケーションログ(NOTICE)
     *
     * @param string $log_ 出力する内容
     * @return なし
     */
    public static function output_log_N($log_) {
        if (preg_match('/N/', OUTPUT_LOG_LEVEL)) {
            self::output_log(self::LOGFILE_NAME, 'N', $log_);
        }
    }

    /**
     * アプリケーションログ(INFO)
     *
     * @param string $log_ 出力する内容
     * @return なし
     */
    public static function output_log_I($log_) {
        if (preg_match('/I/', OUTPUT_LOG_LEVEL)) {
            self::output_log(self::LOGFILE_NAME, 'I', $log_);
        }
    }

    /**
     * アプリケーションログ(WORNING)
     *
     * @param string $log_ 出力する内容
     * @return なし
     */
    public static function output_log_W($log_) {
        if (preg_match('/W/', OUTPUT_LOG_LEVEL)) {
            self::output_log(self::LOGFILE_NAME, 'W', $log_);
        }
    }

    /**
     * アプリケーションログ(ERROR)
     *
     * @param string $log_ 出力する内容
     * @return なし
     */
    public static function output_log_E($log_) {
        if (preg_match('/E/', OUTPUT_LOG_LEVEL)) {
            self::output_log(self::LOGFILE_NAME, 'E', $log_);
        }
    }
    
    /**
     * ログ出力
     *
     * @param string $level_ ログレベル
     * @param string $log_ 出力する内容
     * @return なし
     */
    private static function output_log($logfile_, $level_, $log_) {
        if (file_exists(self::LOGDIR . $logfile_)) {
            // サイズオーバー
            if (filesize(self::LOGDIR . $logfile_) > self::FILESIZE_LIMIT) {
                // 世代交代
                $today = date('YmdHis');
                $archivelogfilePath = self::LOGDIR . $logfile_ . '_' . $today;

                rename(self::LOGDIR . $logfile_, $archivelogfilePath);
            }
        }
        
        $logfile = isset($GLOBALS[$logfile_]) ? $GLOBALS[$logfile_] : null;
        // なければ開く
        if (!$logfile) {
            // 開く
            $logfile = fopen(self::LOGDIR . $logfile_, 'a');

            if (!$logfile) {
                return;
            }

            $GLOBALS[$logfile_] = $logfile;
        }
        else
        {
            // ログファイルストリームを取得
            $logfile = $GLOBALS[$logfile_];
        }

        // タイムスタンプ取得
        $timestamp = date('Y-m-d H:i:s');
        // トレース情報
        $traceInfos = array_reverse(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS));
        $trace = '';
        foreach ($traceInfos as $pos => $data) {
            // 最後の呼び出しはAlLog内での呼び出しのため、表示しない
            if ($pos == (count($traceInfos) - 1)) {
                break;
            }
            if ($pos != 0) {
                $trace .= ' -> ';
            }

            if (array_key_exists('file', $data)) {
                $fileArray = preg_split('/\//', $data['file']);
                $fileName = end($fileArray);
            }
            if (array_key_exists('line', $data)) {
                $trace .= $fileName . '(' . $data['line']  . ')';
            }
        }
        // 出力
        fwrite($logfile,
                '<' . $level_ . '> ' .
                '[' . $timestamp . '] ' .
                '[' . $trace . '] ' .
                $log_ . PHP_EOL);
    }
}

?>
