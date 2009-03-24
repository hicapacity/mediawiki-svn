-- Table for holding user properties.

CREATE TABLE /*_*/user_properties(
  up_user bigint not null,
  up_property varchar(255) not null,
  up_value blob
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/user_properties_user_property on user_properties (up_user,up_property);
CREATE INDEX /*i*/user_properties_property on user_properties (up_property);