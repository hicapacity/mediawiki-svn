-- Creates table math used for caching TeX blocks.  Needs to be run
-- on old installations when adding TeX support (2002-12-26)
-- Or, TeX can be disabled via $wgUseTeX=false in LocalSettings.php

DROP TABLE IF EXISTS math;
CREATE TABLE math (
    math_inputhash char(16) NOT NULL,
    math_outputhash char(16) NOT NULL,
    math_conservative BOOL NOT NULL,
    math_html text NOT NULL,
    UNIQUE KEY math_inputhash (math_inputhash)
);
