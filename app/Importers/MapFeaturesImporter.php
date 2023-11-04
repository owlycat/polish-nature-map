<?php

namespace App\Importers;

use App\Models\Category;

class MapFeaturesImporter {

    protected string $categoryName;

    protected function __construct(string $categoryName) {
        $this->categoryName = $categoryName;

        $this->createCategory($categoryName);
    }

    public function getCategoryName(): string {
        return $this->categoryName;
    }

    private function createCategory(string $categoryName): void {
        $category = Category::where("name", $categoryName)->first();
        if (!$category) {
            $category = Category::create([
                "name" => $categoryName,
            ]);
        }
    }

    public function run(): array {

    }
}
