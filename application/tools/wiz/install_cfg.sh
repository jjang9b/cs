#!/bin/bash

cd ${0%/*};
cd ../../;
app_path=$(pwd);

lower_2=`echo $2 | tr A-Z a-z`

echo -e "[setting] app_path : $app_path \n";

if [ ! -d $app_path/config/development/$1  ]; then

  mkdir $app_path/config/development/$1
  echo -e "[install] 1. mkdir $app_path/config/development/$1 \n";

fi
if [ ! -d $app_path/config/testing/$1  ]; then

  mkdir $app_path/config/testing/$1
  echo -e "[install] 1. mkdir $app_path/config/testing/$1 \n";

fi
if [ ! -d $app_path/config/production/$1  ]; then

  mkdir $app_path/config/production/$1
  echo -e "[install] 1. mkdir $app_path/config/production/$1 \n";

fi

cp $app_path/logs/_system/wiz/config/$1/$2.php $app_path/config/development/$1/$lower_2.php
echo -e "[install] 2. cp $app_path/logs/_system/wiz/config/$1/$2.php $app_path/config/development/$1/$lower_2.php \n";

cp $app_path/logs/_system/wiz/config/$1/$2.php $app_path/config/testing/$1/$lower_2.php
echo -e "[install] 2-1. cp $app_path/logs/_system/wiz/config/$1/$2.php $app_path/config/testing/$1/$lower_2.php \n";

cp $app_path/logs/_system/wiz/config/$1/$2.php $app_path/config/production/$1/$lower_2.php
echo -e "[install] 2-2. cp $app_path/logs/_system/wiz/config/$1/$2.php $app_path/config/production/$1/$lower_2.php \n";

if [ -f $app_path/logs/_system/wiz/config/$1/menu.php ]; then

  cp $app_path/logs/_system/wiz/config/$1/menu.php $app_path/config/development/$1/
  echo -e "[install] 3. cp $app_path/logs/_system/wiz/config/$1/menu.php $app_path/config/development/$1/ \n";

  cp $app_path/logs/_system/wiz/config/$1/menu.php $app_path/config/testing/$1/
  echo -e "[install] 3-1. cp $app_path/logs/_system/wiz/config/$1/menu.php $app_path/config/testing/$1/ \n";

  cp $app_path/logs/_system/wiz/config/$1/menu.php $app_path/config/production/$1/
  echo -e "[install] 3-2. cp $app_path/logs/_system/wiz/config/$1/menu.php $app_path/config/production/$1/ \n";

fi
