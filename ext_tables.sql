#
# Table structure for table 'pages'
#
CREATE TABLE pages (

    tx_crystalis_canonical varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'pages_language_overlay'
#
CREATE TABLE pages_language_overlay (

    tx_crystalis_canonical varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'sys_domain'
#
CREATE TABLE sys_domain (

    tx_crystalis_language varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (

    section_frame int(11) unsigned DEFAULT '0' NOT NULL,
    spaceAfter smallint(5) unsigned DEFAULT '0' NOT NULL,
    spaceBefore smallint(5) unsigned DEFAULT '0' NOT NULL,

);