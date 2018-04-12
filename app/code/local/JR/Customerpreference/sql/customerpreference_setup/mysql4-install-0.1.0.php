<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('customer_preference')};
CREATE TABLE {$this->getTable('customer_preference')} (
  `preference_id` int(11) unsigned NOT NULL auto_increment,
  `entity_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Customer Entity Id',
  `fullname` varchar(255) NOT NULL default '',
  `budget_from` decimal(12,4) NOT NULL DEFAULT '0.0000' COMMENT 'Budget From',
  `budget_to` decimal(12,4) NOT NULL DEFAULT '0.0000' COMMENT 'Budget From',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`preference_id`),
  UNIQUE KEY `UNQ_CUSTOMER_PREFERENCE_ENTITY_ID` (`entity_id`),
  KEY `IDX_CUSTOMER_PREFERENCE_ENTITY_ID` (`entity_id`),
  CONSTRAINT `FK_CUSTOMER_PREFERENCE_ENTITY_ID` FOREIGN KEY (`entity_id`) REFERENCES `customer_entity` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Customer Preference';

DROP TABLE IF EXISTS {$this->getTable('customer_preference_members')};
CREATE TABLE {$this->getTable('customer_preference_members')} (
  `members_id` int(11) unsigned NOT NULL auto_increment,
  `preference_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Preference Id',
  `name` varchar(255) NOT NULL default '',
  `relationship` varchar(255) NULL,
  `age` smallint(6) NULL,
  PRIMARY KEY (`members_id`),
  KEY `IDX_CUSTOMER_PREFERENCE_MEMBERS_PREFERENCE_ID` (`preference_id`),
  CONSTRAINT `FK_CUSTOMER_PREFERENCE_MEMBERS_PREFERENCE_ID` FOREIGN KEY (`preference_id`) REFERENCES `customer_preference` (`preference_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Customer Preference MEMBERS';

DROP TABLE IF EXISTS {$this->getTable('customer_preference_attribute')};
CREATE TABLE {$this->getTable('customer_preference_attribute')} (
  `preference_attr_id` int(11) unsigned NOT NULL auto_increment,
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Id',
  `attribute_code` varchar(100) NOT NULL default '',
  `preference_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'PREFERENCE Id',
  `values` varchar(255) DEFAULT NULL COMMENT 'Value',
  PRIMARY KEY (`preference_attr_id`),
  KEY `IDX_CUSTOMER_PREFERENCE_ATTR_PREFERENCE_ID` (`preference_id`),
  CONSTRAINT `FK_CUSTOMER_PREFERENCE_ATTR_PREFERENCE_ID` FOREIGN KEY (`preference_id`) REFERENCES `customer_preference` (`preference_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Customer Preference ATTRIBUTES';



    ");



$installer->endSetup();
