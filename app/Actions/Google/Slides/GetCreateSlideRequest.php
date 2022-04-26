<?php

namespace App\Actions\Google\Slides;

use Lorisleiva\Actions\Concerns\AsAction;

class GetCreateSlideRequest
{
    use AsAction;

    const SLIDE_WIDTH = 700;
    const COLUMN_SPACING = 30;

    protected $requests = [];
    protected $pageId;
    protected $columnCount = 0;
    protected $columnWidth = 0;
    protected $columnHeight = 0;
    protected $columnSpacing = 0;

    public function handle($slideDefinition)
    {
        // determine page id
        $this->pageId = md5(json_encode($slideDefinition));

        // create slide
        $this->requests[] = new \Google_Service_Slides_Request([
            'createSlide' => [
                'objectId' => $this->pageId,
                'slideLayoutReference' => [
                    'predefinedLayout' => 'TITLE_ONLY',
                ],
                "placeholderIdMappings" => [
                    [
                        "layoutPlaceholder" =>  [
                            "type" => "TITLE",
                            "index" => 0
                        ],
                        "objectId" => $this->pageId . '_title',
                    ],
                ],
            ],
        ]);

        // set title
        $this->requests[] = new \Google_Service_Slides_Request([
            'insertText' => [
                'objectId' => $this->pageId . '_title',
                'text' => data_get($slideDefinition, 'title'),
            ],
        ]);

        // process columns
        $columnData = data_get($slideDefinition, 'columns', []);
        $this->columnCount = count($columnData);
        $this->columnWidth = (self::SLIDE_WIDTH - (2 * self::COLUMN_SPACING) - (($this->columnCount - 1) * self::COLUMN_SPACING)) / $this->columnCount;
        $this->columnHeight = 300;

        foreach ($columnData as $columnIndex => $column) {
            $this->processColumn($columnIndex, $column);
        }

        return $this->requests;
    }

    protected function processColumn($columnIndex, $column)
    {
        $type = strtolower(data_get($column, 'type'));
        if ($type == 'image') {
            $this->processImageColumn($columnIndex, $column);
        } elseif ($type == 'text') {
            $this->processTextColumn($columnIndex, $column);
        }
    }

    protected function processImageColumn($columnIndex, $column)
    {
        $this->requests[] = new \Google_Service_Slides_Request([
            'createImage' => [
                'url' => data_get($column, 'content'),
                'elementProperties' => [
                    'pageObjectId' => $this->pageId,
                    'size' => [
                        'width' => [
                            'magnitude' =>  $this->columnWidth,
                            'unit' => 'PT',
                        ],
                        'height' => [
                            'magnitude' => $this->columnHeight,
                            'unit' => 'PT',
                        ],
                    ],
                    'transform' => [
                        'scaleX' => 1,
                        'scaleY' => 1,
                        'translateX' => ($this->columnWidth * $columnIndex) + (self::COLUMN_SPACING * ($columnIndex + 1)),
                        'translateY' => 75,
                        'unit' => 'PT',
                    ],
                ],
            ],
        ]);
    }

    protected function processTextColumn($columnIndex, $column)
    {
        $objectId = $this->pageId . '_column_' . $columnIndex;
        $this->requests[] = new \Google_Service_Slides_Request([
            'createShape' => [
                'objectId' => $objectId,
                'shapeType' => 'TEXT_BOX',
                'elementProperties' => [
                    'pageObjectId' => $this->pageId,
                    'size' => [
                        'width' => [
                            'magnitude' =>  $this->columnWidth,
                            'unit' => 'PT',
                        ],
                        'height' => [
                            'magnitude' => $this->columnHeight,
                            'unit' => 'PT',
                        ],
                    ],
                    'transform' => [
                        'scaleX' => 1,
                        'scaleY' => 1,
                        'translateX' => ($this->columnWidth * $columnIndex) + (self::COLUMN_SPACING * ($columnIndex + 1)),
                        'translateY' => 75,
                        'unit' => 'PT',
                    ],
                ],
            ],
        ]);
        $this->requests[] = new \Google_Service_Slides_Request([
            'insertText' => [
                'objectId' => $objectId,
                'text' => data_get($column, 'content'),
            ],
        ]);
    }
}
