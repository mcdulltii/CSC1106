BASEDIR=$(dirname $0)

# Migrate SQL tables
docker exec csc1106_webapp php spark migrate

# Create temporary default user
docker exec -i csc1106_mariadb mysql -u mariadb_user -pmariadb_password webapp_db < $BASEDIR/create_user.sql

if [ $? -eq 0 ]; then
  echo "User successfully created"
else
  echo "Failed to create default user"
fi
