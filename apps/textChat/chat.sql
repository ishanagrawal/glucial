CREATE TABLE `text_chat` (
  `uid` int NOT NULL default 0,	
  `chat_id` int NOT NULL default 0,	
  `user_name` varchar(255) NOT NULL default '',
  `text` text,
  `time` time NOT NULL default '00:00:00'
);