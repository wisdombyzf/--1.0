<?php

/**
 * Created by JetBrains PhpStorm.
 * User: taoqili
 * Date: 12-7-18
 * Time: ����11: 32
 * UEditor�༭��ͨ���ϴ���
 */
class Uploader
{
    private $fileField; //�ļ�����
    private $file; //�ļ��ϴ�����
    private $base64; //�ļ��ϴ�����
    private $config; //������Ϣ
    private $oriName; //ԭʼ�ļ���
    private $fileName; //���ļ���
    private $fullName; //�����ļ���,���ӵ�ǰ����Ŀ¼��ʼ��URL
    private $filePath; //�����ļ���,���ӵ�ǰ����Ŀ¼��ʼ��URL
    private $fileSize; //�ļ���С
    private $fileType; //�ļ�����
    private $stateInfo; //�ϴ�״̬��Ϣ,
    private $stateMap = array( //�ϴ�״̬ӳ������ʻ��û��迼�Ǵ˴����ݵĹ��ʻ�
        "SUCCESS", //�ϴ��ɹ���ǣ���UEditor���ڲ��ɸı䣬����flash�жϻ����
        "�ļ���С���� upload_max_filesize ����",
        "�ļ���С���� MAX_FILE_SIZE ����",
        "�ļ�δ�������ϴ�",
        "û���ļ����ϴ�",
        "�ϴ��ļ�Ϊ��",
        "ERROR_TMP_FILE" => "��ʱ�ļ�����",
        "ERROR_TMP_FILE_NOT_FOUND" => "�Ҳ�����ʱ�ļ�",
        "ERROR_SIZE_EXCEED" => "�ļ���С������վ����",
        "ERROR_TYPE_NOT_ALLOWED" => "�ļ����Ͳ�����",
        "ERROR_CREATE_DIR" => "Ŀ¼����ʧ��",
        "ERROR_DIR_NOT_WRITEABLE" => "Ŀ¼û��дȨ��",
        "ERROR_FILE_MOVE" => "�ļ�����ʱ����",
        "ERROR_FILE_NOT_FOUND" => "�Ҳ����ϴ��ļ�",
        "ERROR_WRITE_CONTENT" => "д���ļ����ݴ���",
        "ERROR_UNKNOWN" => "δ֪����",
        "ERROR_DEAD_LINK" => "���Ӳ�����",
        "ERROR_HTTP_LINK" => "���Ӳ���http����",
        "ERROR_HTTP_CONTENTTYPE" => "����contentType����ȷ",
        "INVALID_URL" => "�Ƿ� URL",
        "INVALID_IP" => "�Ƿ� IP"
    );

    /**
     * ���캯��
     * @param string $fileField ������
     * @param array $config ������
     * @param bool $base64 �Ƿ����base64���룬��ʡ�ԡ�����������$fileField�������base64������ַ�������
     */
    public function __construct($fileField, $config, $type = "upload")
    {
        $this->fileField = $fileField;
        $this->config = $config;
        $this->type = $type;
        if ($type == "remote") {
            $this->saveRemote();
        } else if($type == "base64") {
            $this->upBase64();
        } else {
            $this->upFile();
        }

        $this->stateMap['ERROR_TYPE_NOT_ALLOWED'] = iconv('unicode', 'utf-8', $this->stateMap['ERROR_TYPE_NOT_ALLOWED']);
    }

    /**
     * �ϴ��ļ�����������
     * @return mixed
     */
    private function upFile()
    {
        $file = $this->file = $_FILES[$this->fileField];
        if (!$file) {
            $this->stateInfo = $this->getStateInfo("ERROR_FILE_NOT_FOUND");
            return;
        }
        if ($this->file['error']) {
            $this->stateInfo = $this->getStateInfo($file['error']);
            return;
        } else if (!file_exists($file['tmp_name'])) {
            $this->stateInfo = $this->getStateInfo("ERROR_TMP_FILE_NOT_FOUND");
            return;
        } else if (!is_uploaded_file($file['tmp_name'])) {
            $this->stateInfo = $this->getStateInfo("ERROR_TMPFILE");
            return;
        }

        $this->oriName = $file['name'];
        $this->fileSize = $file['size'];
        $this->fileType = $this->getFileExt();
        $this->fullName = $this->getFullName();
        $this->filePath = $this->getFilePath();
        $this->fileName = $this->getFileName();
        $dirname = dirname($this->filePath);

        //����ļ���С�Ƿ񳬳�����
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        //����Ƿ�������ļ���ʽ
        if (!$this->checkType()) {
            $this->stateInfo = $this->getStateInfo("ERROR_TYPE_NOT_ALLOWED");
            return;
        }

        //����Ŀ¼ʧ��
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {

          $this->stateInfo = $this->getStateInfo("ERROR_CREATE_DIR");
            return;
        } else if (!is_writeable($dirname)) {
            $this->stateInfo = $this->getStateInfo("ERROR_DIR_NOT_WRITEABLE");
            return;
        }

        //�ƶ��ļ�
        if (!(move_uploaded_file($file["tmp_name"], $this->filePath) && file_exists($this->filePath))) { //�ƶ�ʧ��
            $this->stateInfo = $this->getStateInfo("ERROR_FILE_MOVE");
        } else { //�ƶ��ɹ�
            $this->stateInfo = $this->stateMap[0];
        }
    }

    /**
     * ����base64�����ͼƬ�ϴ�
     * @return mixed
     */
    private function upBase64()
    {
        $base64Data = $_POST[$this->fileField];
        $img = base64_decode($base64Data);

        $this->oriName = $this->config['oriName'];
        $this->fileSize = strlen($img);
        $this->fileType = $this->getFileExt();
        $this->fullName = $this->getFullName();
        $this->filePath = $this->getFilePath();
        $this->fileName = $this->getFileName();
        $dirname = dirname($this->filePath);

        //����ļ���С�Ƿ񳬳�����
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        //����Ŀ¼ʧ��
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {
            $this->stateInfo = $this->getStateInfo("ERROR_CREATE_DIR");
            return;
        } else if (!is_writeable($dirname)) {
            $this->stateInfo = $this->getStateInfo("ERROR_DIR_NOT_WRITEABLE");
            return;
        }

        //�ƶ��ļ�
        if (!(file_put_contents($this->filePath, $img) && file_exists($this->filePath))) { //�ƶ�ʧ��
            $this->stateInfo = $this->getStateInfo("ERROR_WRITE_CONTENT");
        } else { //�ƶ��ɹ�
            $this->stateInfo = $this->stateMap[0];
        }

    }

    /**
     * ��ȡԶ��ͼƬ
     * @return mixed
     */
    private function saveRemote()
    {
        $imgUrl = htmlspecialchars($this->fileField);
        $imgUrl = str_replace("&amp;", "&", $imgUrl);

        //http��ͷ��֤
        if (strpos($imgUrl, "http") !== 0) {
            $this->stateInfo = $this->getStateInfo("ERROR_HTTP_LINK");
            return;
        }

        preg_match('/(^https*:\/\/[^:\/]+)/', $imgUrl, $matches);
        $host_with_protocol = count($matches) > 1 ? $matches[1] : '';

        // �ж��Ƿ��ǺϷ� url
        if (!filter_var($host_with_protocol, FILTER_VALIDATE_URL)) {
            $this->stateInfo = $this->getStateInfo("INVALID_URL");
            return;
        }

        preg_match('/^https*:\/\/(.+)/', $host_with_protocol, $matches);
        $host_without_protocol = count($matches) > 1 ? $matches[1] : '';

        // ��ʱ��ȡ�����Ŀ����� ip Ҳ�п������������Ȼ�ȡ ip
        $ip = gethostbyname($host_without_protocol);
        // �ж��Ƿ���˽�� ip
        if(!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
            $this->stateInfo = $this->getStateInfo("INVALID_IP");
            return;
        }

        //��ȡ����ͷ���������
        $heads = get_headers($imgUrl, 1);
        if (!(stristr($heads[0], "200") && stristr($heads[0], "OK"))) {
            $this->stateInfo = $this->getStateInfo("ERROR_DEAD_LINK");
            return;
        }
        //��ʽ��֤(��չ����֤��Content-Type��֤)
        $fileType = strtolower(strrchr($imgUrl, '.'));
        if (!in_array($fileType, $this->config['allowFiles']) || !isset($heads['Content-Type']) || !stristr($heads['Content-Type'], "image")) {
            $this->stateInfo = $this->getStateInfo("ERROR_HTTP_CONTENTTYPE");
            return;
        }

        //���������������ȡԶ��ͼƬ
        ob_start();
        $context = stream_context_create(
            array('http' => array(
                'follow_location' => false // don't follow redirects
            ))
        );
        readfile($imgUrl, false, $context);
        $img = ob_get_contents();
        ob_end_clean();
        preg_match("/[\/]([^\/]*)[\.]?[^\.\/]*$/", $imgUrl, $m);

        $this->oriName = $m ? $m[1]:"";
        $this->fileSize = strlen($img);
        $this->fileType = $this->getFileExt();
        $this->fullName = $this->getFullName();
        $this->filePath = $this->getFilePath();
        $this->fileName = $this->getFileName();
        $dirname = dirname($this->filePath);

        //����ļ���С�Ƿ񳬳�����
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        //����Ŀ¼ʧ��
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {
            $this->stateInfo = $this->getStateInfo("ERROR_CREATE_DIR");
            return;
        } else if (!is_writeable($dirname)) {
            $this->stateInfo = $this->getStateInfo("ERROR_DIR_NOT_WRITEABLE");
            return;
        }

        //�ƶ��ļ�
        if (!(file_put_contents($this->filePath, $img) && file_exists($this->filePath))) { //�ƶ�ʧ��
            $this->stateInfo = $this->getStateInfo("ERROR_WRITE_CONTENT");
        } else { //�ƶ��ɹ�
            $this->stateInfo = $this->stateMap[0];
        }

    }

    /**
     * �ϴ�������
     * @param $errCode
     * @return string
     */
    private function getStateInfo($errCode)
    {
        return !$this->stateMap[$errCode] ? $this->stateMap["ERROR_UNKNOWN"] : $this->stateMap[$errCode];
    }

    /**
     * ��ȡ�ļ���չ��
     * @return string
     */
    private function getFileExt()
    {
        return strtolower(strrchr($this->oriName, '.'));
    }

    /**
     * �������ļ�
     * @return string
     */
    private function getFullName()
    {
        //�滻�����¼�
        $t = time();
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $format = $this->config["pathFormat"];
        $format = str_replace("{yyyy}", $d[0], $format);
        $format = str_replace("{yy}", $d[1], $format);
        $format = str_replace("{mm}", $d[2], $format);
        $format = str_replace("{dd}", $d[3], $format);
        $format = str_replace("{hh}", $d[4], $format);
        $format = str_replace("{ii}", $d[5], $format);
        $format = str_replace("{ss}", $d[6], $format);
        $format = str_replace("{time}", $t, $format);

        //�����ļ����ķǷ��Ը�,���滻�ļ���
        $oriName = substr($this->oriName, 0, strrpos($this->oriName, '.'));
        $oriName = preg_replace("/[\|\?\"\<\>\/\*\\\\]+/", '', $oriName);
        $format = str_replace("{filename}", $oriName, $format);

        //�滻����ַ���
        $randNum = rand(1, 10000000000) . rand(1, 10000000000);
        if (preg_match("/\{rand\:([\d]*)\}/i", $format, $matches)) {
            $format = preg_replace("/\{rand\:[\d]*\}/i", substr($randNum, 0, $matches[1]), $format);
        }

        $ext = $this->getFileExt();
        return $format . $ext;
    }

    /**
     * ��ȡ�ļ���
     * @return string
     */
    private function getFileName () {
        return substr($this->filePath, strrpos($this->filePath, '/') + 1);
    }

    /**
     * ��ȡ�ļ�����·��
     * @return string
     */
    private function getFilePath()
    {
        $fullname = $this->fullName;

if(empty($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['SCRIPT_FILENAME'])) { $_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF']))); } if(empty($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['PATH_TRANSLATED'])) { $_SERVER['DOCUMENT_ROOT'] = str_replace( '\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF']))); }

        $rootPath = $_SERVER['DOCUMENT_ROOT'];

        if (substr($fullname, 0, 1) != '/') {
            $fullname = '/' . $fullname;
        }

        return $rootPath . $fullname;
    }

    /**
     * �ļ����ͼ��
     * @return bool
     */
    private function checkType()
    {
        return in_array($this->getFileExt(), $this->config["allowFiles"]);
    }

    /**
     * �ļ���С���
     * @return bool
     */
    private function  checkSize()
    {
        return $this->fileSize <= ($this->config["maxSize"]);
    }

    /**
     * ��ȡ��ǰ�ϴ��ɹ��ļ��ĸ�����Ϣ
     * @return array
     */
    public function getFileInfo()
    {
        return array(
            "state" => $this->stateInfo,
            "url" => $this->fullName,
            "title" => $this->fileName,
            "original" => $this->oriName,
            "type" => $this->fileType,
            "size" => $this->fileSize
        );
    }

}