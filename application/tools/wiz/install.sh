#!/bin/bash

cd ${0%/*};
cd ../../;
app_path=$(pwd);
echo -e "[setting] app_path : $app_path \n";

cd ../webroot;
web_path=$(pwd);
echo -e "[setting] web_path: $web_path \n";

if [ ! -d $app_path/controllers/$1  ]; then

  mkdir $app_path/controllers/$1;
  echo -e "[install] 1. mkdir $app_path/controllers/$1 \n";

fi

cp $app_path/controllers/base/$2.php $app_path/controllers/$1/$2.php
echo -e "[install] 2. cp $app_path/controllers/base/$2.php $app_path/controllers/$1/$2.php \n";

if [ ! -d $app_path/models/$1  ]; then

  mkdir $app_path/models/$1
  echo -e "[install] 3. mkdir $app_path/models/$1 \n";

fi

lower_2=`echo $2 | tr A-Z a-z`

cp $app_path/models/base/"$lower_2"_dao.php $app_path/models/$1/
echo -e "[install] 4. cp $app_path/models/base/"$lower_2"_dao.php $app_path/models/$1/ \n";


if [ ! -d $app_path/views/$1  ]; then

  mkdir $app_path/views/$1
  echo -e "[install] 5. mkdir $app_path/views/$1 \n";

fi

cp $app_path/views/wiz/base/$2_*.php $app_path/views/$1/
echo -e "[install] 6. cp $app_path/views/wiz/base/$2_*.php $app_path/views/$1/ \n";

if [ ! -d $web_path/res/js/game  ]; then
  mkdir $web_path/res/js/game
  echo -e "[install] 7-1. mkdir $web_path/res/js/game";
  
fi

if [ ! -f $web_path/res/js/game/$1.js ]; then
  cp $web_path/res/js/wiz/game.js $web_path/res/js/game/$1.js
  echo -e "[install] 7-2. cp $web_path/res/js/wiz/game.js $web_path/res/js/game/$1.js";
fi
