<?php

namespace Mawuekom\Systhemer\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class MakeThemeCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:theme {theme?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new theme.';

    /**
     * @var string
     */
    public $theme;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this ->theme = $this ->askTheme();

        $this->line("<options=bold>Theme Name:</options=bold> {$this->theme}");
        $this->line('');

        $this ->info("Theme scaffolding installed successfully.\n");
    }

    /**
     * Ask theme's name
     * 
     * @return string $theme
     */
    protected function askTheme()
    {
        $theme = $this->argument('theme');

        if (! $theme) {
            $theme = $this->askValid(
                'Name of your theme',
                'theme',
                ['required']
            );
        }

        return $theme;
    }

    /**
     * Ask question and validate response
     * 
     * @param string $question
     * @param string $field
     * @param array $rules
     * 
     * @return string $value
     */
    protected function askValid(string $question, string $field, array $rules)
    {
        $value = $this->ask($question);

        if ($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }

    /**
     * Validate incoming input arguments
     * 
     * @param string|array $rules
     * @param string $fieldName
     * @param string $value
     * 
     * @return null|string
     */
    protected function validateInput($rules, $fieldName, $value): ?string
    {
        $validator = Validator::make([
            $fieldName => $value,
        ], [
            $fieldName => $rules,
        ]);

        return $validator->fails()
                ? $validator->errors()->first($fieldName)
                : null;
    }
}