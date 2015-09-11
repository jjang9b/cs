#!/bin/bash

cd ${0%/*};
cd ../../;
app_path=$(pwd);
echo -e "[setting] app_path : $app_path \n";

cd ../webroot;
web_path=$(pwd);
echo -e "[setting] web_path: $web_path \n";

lower_2=`echo $2 | tr A-Z a-z`
lower_3=`echo $3 | tr A-Z a-z`

if [ ! -d $app_path/controllers/$1  ]; then

  mkdir $app_path/controllers/$1;
  echo -e "[install] 1. mkdir $app_path/controllers/$1 \n";

fi

cp $app_path/controllers/base/$2.php $app_path/controllers/$1/"$lower_3".php
echo -e "[install] 2. cp $app_path/controllers/base/$2.php $app_path/controllers/$1/"$lower_3".php \n";

if [ ! -d $app_path/models/$1  ]; then

  mkdir $app_path/models/$1
  echo -e "[install] 3. mkdir $app_path/models/$1 \n";

fi

cp $app_path/models/base/"$lower_2"_dao.php $app_path/models/$1/"$lower_3"_dao.php
echo -e "[install] 4. cp $app_path/models/base/"$lower_2"_dao.php $app_path/models/$1/"$lower_3"_dao.php \n";


if [ ! -d $app_path/views/$1  ]; then

  mkdir $app_path/views/$1
  echo -e "[install] 5. mkdir $app_path/views/$1 \n";

fi

cp $app_path/views/wiz/base/$2_*.php $app_path/views/$1/
echo -e "[install] 6-1. cp $app_path/views/wiz/base/$2_*.php $app_path/views/$1/ \n";

rename $2 $lower_3 $app_path/views/$1/"$2"_*.php
echo -e "[install] 6-2. rename $2 $lower_3 $app_path/views/$1/"$2"_*.php \n";

cname_2=$2;
cname_3=$3;

find $app_path/controllers/$1/ -name ""$lower_3".php" -exec sed -i "s/class ${cname_2^}/class ${cname_3^}/g" {} \;
find $app_path/controllers/$1/ -name ""$lower_3".php" -exec sed -i "s/\/"$2"/\/"$lower_3"/g" {} \;
find $app_path/controllers/$1/ -name ""$lower_3".php" -exec sed -i "s/"$2"_dao/"$lower_3"_dao/g" {} \;

find $app_path/models/$1/ -name ""$lower_3"_dao.php" -exec sed -i "s/class ${cname_2^}_dao/class ${cname_3^}_dao/g" {} \;

echo -e "[install] 7-1. find $app_path/controllers/$1/ -name "$3.php" -exec sed -i "s/class ${cname_2^}/class ${cname_3^}/g" {} \; \n";
echo -e "[install] 7-2. find $app_path/controllers/$1/ -name "$3.php" -exec sed -i "s/\/"$2"/\/"$lower_3"/g" {} \; \n";
echo -e "[install] 7-3. find $app_path/controllers/$1/ -name "$3.php" -exec sed -i "s/"$2"_dao/"$lower_3"_dao/g" {} \; \n";
echo -e "[install] 7-4. find $app_path/models/$1/ -name "$3_dao.php" -exec sed -i "s/class ${cname_2^}_dao/class ${cname_3^}_dao/g" {} \; \n";

if [ ! -d $web_path/res/js/game  ]; then
  mkdir $web_path/res/js/game
  echo -e "[install] 8-1. mkdir $web_path/res/js/game";
  
fi

if [ ! -f $web_path/res/js/game/$1.js ]; then
  cp $web_path/res/js/wiz/game.js $web_path/res/js/game/$1.js
  echo -e "[install] 8-2. cp $web_path/res/js/wiz/game.js $web_path/res/js/game/$1.js";
fi
