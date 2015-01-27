-- Create the projects table
CREATE  TABLE "main"."projets" (
"id" INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL  UNIQUE , 
"order" INTEGER NOT NULL  DEFAULT 1,
"name" VARCHAR DEFAULT "Mon Projet", 
"url" VARCHAR UNIQUE DEFAULT "mon_projet" , 
"main_img" VARCHAR DEFAULT "asset/images/background/bg4.png", 
"main_color" VARCHAR DEFAULT "green accent-4", 
"short_desc" VARCHAR DEFAULT "Description", 
"goal" VARCHAR DEFAULT "But du projet",
 "description" VARCHAR DEFAULT "Description",
"techno" VARCHAR DEFAULT "Technologies utilisées");

