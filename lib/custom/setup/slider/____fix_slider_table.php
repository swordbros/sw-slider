<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->fix_slider_tables();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        try{
            echo " `sw_slider`, `sw_slider_list`, `sw_slider_list_type`, `sw_slider_type` is Dropping...\r\n";
            DB::statement("DROP TABLE `sw_slider`, `sw_slider_list`, `sw_slider_list_type`, `sw_slider_type`;");
            echo " Tables Dropped ✓\r\n";
        } catch(Exception $ex){
            echo " Dropping is terminated. \r\n";
        }

    }
    
    private static function fix_slider_tables(){
        $sw_slider = "CREATE TABLE `sw_slider` (
  `id` int(11) NOT NULL,
  `siteid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varbinary(64) NOT NULL,
  `code` varbinary(64) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `config` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pos` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `mtime` datetime NOT NULL,
  `ctime` datetime NOT NULL,
  `editor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sw_slider_list` (
  `id` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `siteid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varbinary(134) NOT NULL DEFAULT '',
  `type` varbinary(64) NOT NULL,
  `domain` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refid` varbinary(36) NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `config` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pos` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `mtime` datetime NOT NULL,
  `ctime` datetime NOT NULL,
  `editor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sw_slider_list_type` (
  `id` int(11) NOT NULL,
  `siteid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varbinary(64) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pos` int(11) NOT NULL DEFAULT 0,
  `status` smallint(6) NOT NULL,
  `mtime` datetime NOT NULL,
  `ctime` datetime NOT NULL,
  `editor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sw_slider_type` (
  `id` int(11) NOT NULL,
  `siteid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varbinary(64) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pos` int(11) NOT NULL DEFAULT 0,
  `status` smallint(6) NOT NULL,
  `mtime` datetime NOT NULL,
  `ctime` datetime NOT NULL,
  `editor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `sw_slider`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_msser_siteid_code` (`siteid`,`code`),
  ADD KEY `idx_msser_sid_stat_start_end` (`siteid`,`status`,`start`,`end`),
  ADD KEY `idx_msser_sid_prov` (`siteid`,`provider`),
  ADD KEY `idx_msser_sid_code` (`siteid`,`code`),
  ADD KEY `idx_msser_sid_label` (`siteid`,`label`),
  ADD KEY `idx_msser_sid_pos` (`siteid`,`pos`);

ALTER TABLE `sw_slider_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_msserli_pid_sid_dm_ty_rid` (`parentid`,`siteid`,`domain`,`type`,`refid`),
  ADD KEY `idx_msserli_sid_key` (`siteid`,`key`),
  ADD KEY `fk_msserli_pid` (`parentid`);

ALTER TABLE `sw_slider_list_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_msserlity_sid_dom_code` (`siteid`,`domain`,`code`),
  ADD KEY `idx_msserlity_sid_status_pos` (`siteid`,`status`,`pos`),
  ADD KEY `idx_msserlity_sid_label` (`siteid`,`label`),
  ADD KEY `idx_msserlity_sid_code` (`siteid`,`code`);

ALTER TABLE `sw_slider_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_msserty_sid_dom_code` (`siteid`,`domain`,`code`),
  ADD KEY `idx_msserty_sid_status_pos` (`siteid`,`status`,`pos`),
  ADD KEY `idx_msserty_sid_label` (`siteid`,`label`),
  ADD KEY `idx_msserty_sid_code` (`siteid`,`code`);

ALTER TABLE `sw_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `sw_slider_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `sw_slider_list_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `sw_slider_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `sw_slider` (`id`, `siteid`, `type`, `code`, `label`, `provider`, `start`, `end`, `config`, `pos`, `status`, `mtime`, `ctime`, `editor`, `domain`) VALUES
(1, '1.', 0x7374616e64617264, 0x686f6d652d706167652d736c69646572, 'Home Page Standard Slider', '', NULL, NULL, '[]', 0, 0, '2020-10-04 23:38:25', '2020-10-04 23:12:35', 'ahmethamdibayrak@hotmail.com', 'media'),
(2, '1.', 0x636f7665722d666c6f77, 0x686f6d652d706167652d636f7765722d666c6f772d736c69646572, 'Home Page  Cover Flow Slider', '', NULL, NULL, '[]', 0, 1, '2020-10-04 23:39:15', '2020-10-04 23:14:37', 'ahmethamdibayrak@hotmail.com', 'media'),
(3, '1.', 0x7374616e64617264, 0x686f6d652d706167652d736c69646572, 'List Page Standard Banner', '', NULL, NULL, '[]', 0, 0, '2020-10-04 23:38:25', '2020-10-04 23:12:35', 'ahmethamdibayrak@hotmail.com', 'media');

INSERT INTO `mshop_media` (`id`, `siteid`, `type`, `langid`, `domain`, `label`, `link`, `preview`, `mimetype`, `status`, `mtime`, `ctime`, `editor`) VALUES
(57, '1.', 0x64656661756c74, NULL, 'slider', 'slider-2-b.png', 'files/b/8/b8d5c9ad_1118837782.png', '{\"240\":\"preview\\/6\\/a\\/6a009ed3_1090084149.png\",\"500\":\"preview\\/b\\/6\\/b6fbbad2_1906709993.png\"}', 'image/png', 1, '2020-10-09 22:01:19', '2020-10-09 22:01:19', ''),
(58, '1.', 0x64656661756c74, NULL, 'slider', 'slider-4-b.png', 'files/7/e/7e02e8f3_1803398528.png', '{\"240\":\"preview\\/1\\/9\\/1906aa66_1403155064.png\",\"500\":\"preview\\/6\\/7\\/67d2d597_1898804800.png\"}', 'image/png', 1, '2020-10-09 22:01:19', '2020-10-09 22:01:19', ''),
(59, '1.', 0x64656661756c74, NULL, 'slider', 'slider-5-b.png', 'files/9/8/98b4aa2f_1273691822.png', '{\"240\":\"preview\\/8\\/6\\/86f6ba4b_918413810.png\",\"500\":\"preview\\/2\\/c\\/2cd27d2e_335773123.png\"}', 'image/png', 1, '2020-10-09 22:21:57', '2020-10-09 22:21:57', ''),
(60, '1.', 0x64656661756c74, NULL, 'slider', 'slider-1-b.png', 'files/3/6/36a26a9c_500715801.png', '{\"240\":\"preview\\/f\\/0\\/f096ebd2_1130715880.png\",\"500\":\"preview\\/b\\/a\\/ba143752_648651192.png\"}', 'image/png', 1, '2020-10-09 22:21:57', '2020-10-09 22:21:57', ''),
(61, '1.', 0x64656661756c74, NULL, 'slider', 'slider-6-b.png', 'files/7/4/74e17f1b_828353761.png', '{\"240\":\"preview\\/9\\/e\\/9ed75573_636623554.png\",\"500\":\"preview\\/2\\/f\\/2fb4a656_1305322370.png\"}', 'image/png', 1, '2020-10-09 22:22:33', '2020-10-09 22:22:33', ''),
(62, '1.', 0x64656661756c74, NULL, 'slider', 'slider-s-1.jpg', 'files/0/7/07526c98_1061709060.jpg', '{\"240\":\"preview\\/9\\/d\\/9db3ed56_635467897.jpg\",\"720\":\"preview\\/4\\/e\\/4e76cd25_92649660.jpg\",\"1170\":\"preview\\/e\\/1\\/e167069e_1201313556.jpg\"}', 'image/jpeg', 1, '2020-10-09 22:34:23', '2020-10-09 22:34:23', ''),
(63, '1.', 0x64656661756c74, NULL, 'slider', 'slider-s-2.jpg', 'files/a/2/a2b0cc28_90220274.jpg', '{\"240\":\"preview\\/6\\/5\\/6514d3be_1827621588.jpg\",\"720\":\"preview\\/2\\/6\\/26742bd2_1801721460.jpg\",\"1170\":\"preview\\/5\\/b\\/5bb0d3fd_1758668177.jpg\"}', 'image/jpeg', 1, '2020-10-09 22:34:23', '2020-10-09 22:34:23', ''),
(64, '1.', 0x64656661756c74, NULL, 'slider', 'slider-s-3.jpg', 'files/c/4/c4d7c52a_1234057900.jpg', '{\"240\":\"preview\\/d\\/8\\/d88470b7_861133346.jpg\",\"720\":\"preview\\/f\\/4\\/f4b5af41_1804334465.jpg\",\"1170\":\"preview\\/d\\/7\\/d75acb1f_2105346967.jpg\"}', 'image/jpeg', 1, '2020-10-09 22:34:23', '2020-10-09 22:34:23', '');

INSERT INTO `sw_slider_list` (`id`, `parentid`, `siteid`, `key`, `type`, `domain`, `refid`, `start`, `end`, `config`, `pos`, `status`, `mtime`, `ctime`, `editor`) VALUES
(8, 2, '1.', 0x6d656469617c7374616e646172747c3537, 0x7374616e64617274, 'media', 0x3537, NULL, NULL, '{\"content-de\":\"\",\"url-de\":\"\",\"content-en\":\"\",\"url-en\":\"\"}', 0, 1, '2020-10-09 22:21:57', '2020-10-09 22:01:19', ''),
(9, 2, '1.', 0x6d656469617c7374616e646172747c3538, 0x7374616e64617274, 'media', 0x3538, NULL, NULL, '{\"content-de\":\"\",\"url-de\":\"\",\"content-en\":\"\",\"url-en\":\"\"}', 1, 1, '2020-10-09 22:21:57', '2020-10-09 22:01:19', ''),
(10, 2, '1.', 0x6d656469617c7374616e646172747c3539, 0x7374616e64617274, 'media', 0x3539, NULL, NULL, '{\"content-de\":\"\",\"url-de\":\"\",\"content-en\":\"\",\"url-en\":\"\"}', 2, 1, '2020-10-09 22:22:33', '2020-10-09 22:21:57', ''),
(11, 2, '1.', 0x6d656469617c7374616e646172747c3630, 0x7374616e64617274, 'media', 0x3630, NULL, NULL, '{\"content-de\":\"\",\"url-de\":\"\",\"content-en\":\"\",\"url-en\":\"\"}', 3, 1, '2020-10-09 22:22:33', '2020-10-09 22:21:57', ''),
(12, 2, '1.', 0x6d656469617c7374616e646172747c3631, 0x7374616e64617274, 'media', 0x3631, NULL, NULL, '{\"content-de\":\"\",\"url-de\":\"\",\"content-en\":\"\",\"url-en\":\"\"}', 4, 1, '2020-10-09 22:23:50', '2020-10-09 22:22:33', '');

INSERT INTO `sw_slider_type` (`id`, `siteid`, `domain`, `code`, `label`, `pos`, `status`, `mtime`, `ctime`, `editor`) VALUES
(1, '1.', 'slider', 0x7374616e64617264, 'Standard Slider', 0, 1, '2020-10-04 23:16:33', '2020-10-04 23:11:18', 'ahmethamdibayrak@hotmail.com'),
(2, '1.', 'slider', 0x636f7665722d666c6f77, 'Cover Flow Slider', 0, 1, '2020-10-04 23:11:50', '2020-10-04 23:11:50', 'ahmethamdibayrak@hotmail.com'),
(3, '1.', 'slider', 6c6973742d62616e6e6572, 'List Banner', 0, 1, '2020-10-04 23:16:33', '2020-10-04 23:11:18', 'ahmethamdibayrak@hotmail.com');";
        foreach(explode(';', $sw_slider) as $sql){
            if(!empty($sql)){
                $parts = explode('`', $sql);
                echo " ".$parts[1]." Table checking..... ";
                try{
                    DB::statement($sql);
                    echo $parts[1]." Table created ✓\r\n";
                } catch(Exception $ex){
                    echo " Table is exists. \r\n";
                }
            }
        }

    }

}
