#!/usr/bin/env bash


which -a yarn
if [ "$?" -ne 0 ]; then
  echo -e "${RED}Yarn not found. Exiting...${NC}"

fi

which -a npm
if [ "$?" -ne 0 ]; then
  echo -e "${RED}npm not found. Exiting...${NC}"
fi

which -a composer
if [ "$?" -ne 0 ]; then
  echo -e "${RED}Composer not found. Exiting...${NC}"
fi

which -a docker-compose
if [ "$?" -ne 0 ]; then
  echo -e "${RED}docker-compose not found. Exiting...${NC}"
fi