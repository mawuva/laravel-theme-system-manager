<?php

namespace Mawuekom\Systhemer\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Mawuekom\Systhemer\Theme\Builder\ThemeBuilder;
use Mawuekom\Systhemer\Theme\Theme;

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
     * Theme's name
     * 
     * @var string
     */
    public $theme;

    /**
     * Theme's description
     * 
     * @var string
     */
    public $themeDescription;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this ->theme = $this ->askTheme();

        systhemer() ->ensureThemesDirectoryExists();

        try {
            (new ThemeBuilder($this ->getTheme())) ->execute();

            $this->line("<options=bold>Theme Name:</options=bold> {$this->theme}");
            $this->line('');

            $this ->info("Theme scaffolding installed successfully.\n");
        }

        catch (\Exception $e) {
            $this->error($e ->getMessage());
            return;
        }
    }

    /**
     * Create Thme instance from given responses
     *
     * @return \Mawuekom\Systhemer\Theme\Theme
     */
    public function getTheme()
    {
        return new Theme(
            $this ->theme,
            $this ->themeDescription,
            resolve_theme_path($this ->theme)
        );
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
     * Ask theme's description
     * 
     * @return string $themeDescription
     */
    protected function askThemeDescription()
    {
        $themeDescription = $this->argument('themeDescription');

        if (! $themeDescription) {
            $themeDescription = $this->askValid(
                'Description of your theme',
                'themeDescription',
                []
            );
        }

        return $themeDescription;
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