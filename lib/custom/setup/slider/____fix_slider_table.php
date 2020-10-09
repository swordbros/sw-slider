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
(2, '1.', 0x636f7665722d666c6f77, 0x686f6d652d706167652d636f7765722d666c6f772d736c69646572, 'Home Page  Cover Flow Slider', '', NULL, NULL, '[]', 0, 1, '2020-10-04 23:39:15', '2020-10-04 23:14:37', 'ahmethamdibayrak@hotmail.com', 'media');

INSERT INTO `sw_slider_list` (`id`, `parentid`, `siteid`, `key`, `type`, `domain`, `refid`, `start`, `end`, `config`, `pos`, `status`, `mtime`, `ctime`, `editor`) VALUES
(1, 1, '1.', 0x6d656469617c7374616e646172747c313231, 0x7374616e64617274, 'media', 0x313231, NULL, NULL, '[]', 0, 1, '2020-10-04 23:35:18', '2020-10-04 23:35:18', 'ahmethamdibayrak@hotmail.com'),
(2, 1, '1.', 0x6d656469617c7374616e646172747c313232, 0x7374616e64617274, 'media', 0x313232, NULL, NULL, '[]', 1, 1, '2020-10-04 23:35:18', '2020-10-04 23:35:18', 'ahmethamdibayrak@hotmail.com'),
(3, 2, '1.', 0x6d656469617c7374616e646172747c313233, 0x7374616e64617274, 'media', 0x313233, NULL, NULL, '[]', 0, 1, '2020-10-04 23:36:09', '2020-10-04 23:36:09', 'ahmethamdibayrak@hotmail.com'),
(4, 2, '1.', 0x6d656469617c7374616e646172747c313234, 0x7374616e64617274, 'media', 0x313234, NULL, NULL, '[]', 1, 1, '2020-10-04 23:36:09', '2020-10-04 23:36:09', 'ahmethamdibayrak@hotmail.com'),
(5, 2, '1.', 0x6d656469617c7374616e646172747c313235, 0x7374616e64617274, 'media', 0x313235, NULL, NULL, '[]', 2, 1, '2020-10-04 23:36:09', '2020-10-04 23:36:09', 'ahmethamdibayrak@hotmail.com'),
(6, 2, '1.', 0x6d656469617c7374616e646172747c313236, 0x7374616e64617274, 'media', 0x313236, NULL, NULL, '[]', 3, 1, '2020-10-04 23:39:15', '2020-10-04 23:39:15', 'ahmethamdibayrak@hotmail.com'),
(7, 2, '1.', 0x6d656469617c7374616e646172747c313237, 0x7374616e64617274, 'media', 0x313237, NULL, NULL, '[]', 4, 1, '2020-10-04 23:39:15', '2020-10-04 23:39:15', 'ahmethamdibayrak@hotmail.com');

INSERT INTO `sw_slider_type` (`id`, `siteid`, `domain`, `code`, `label`, `pos`, `status`, `mtime`, `ctime`, `editor`) VALUES
(1, '1.', 'slider', 0x7374616e64617264, 'Standard Slider', 0, 1, '2020-10-04 23:16:33', '2020-10-04 23:11:18', 'ahmethamdibayrak@hotmail.com'),
(2, '1.', 'slider', 0x636f7665722d666c6f77, 'Cover Flow Slider', 0, 1, '2020-10-04 23:11:50', '2020-10-04 23:11:50', 'ahmethamdibayrak@hotmail.com');";
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
