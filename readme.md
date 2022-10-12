# symfony Frontend

composer require symfony/webpack-encore-bundle

npm install bootstrap --save-dev

npm run watch
npm run dev-server
npm run dev
npm run build

npm install jquery --save-dev

# Test unit

composer req --dev dama/doctrine-test-bundle

- Creer une base de donnees test: on modif file composer.json
  ```

    "scripts": {
        "prepare-test": [
            "php bin/console d:d:d --if-exists --force --env=test",
            "php bin/console d:d:c --env=test",
            "php bin/console d:s:u -f --env=test",
            "php bin/console d:f:l -n --env=test"
        ]
    }

```

# Twig component
composer req symfony/ux-twig-component

# test
