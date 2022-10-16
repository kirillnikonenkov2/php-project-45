install:
		composer install

brain-games:
		./bin/brain-games

brain-even:
		./bin/brain-even

brain-calc:
		./bin/brain-calc

allow-exec:
		chmod +x bin/${file}

validate:
		composer validate

lint:
		composer exec --verbose phpcs -- --standard=PSR12 src bin