<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="simplebars.css" />
        <style>
            .graph {
                margin-bottom: 3em;
            }
            
            .styled .data {
                background: #f0f0f0;
            }

            .styled .label {
                color: #009900;
                font-weight: bold;
            }
            
            .styled .bar {
                background: #aa0000;
            }
            
            .styled .bar:hover {
                background: #cc0000;
            }
        </style>
    </head>
    <body>

        <?php
        include("SimpleBars.php");

        $graph = new SimpleBars();
        $graph
            ->setTitle("Manually chosen maximum")
            ->setData(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10))
            ->setOuterMin(50)
            ->setMaxValue(25);
        echo $graph->render();

        $graph = new SimpleBars();
        $graph
            ->setTitle("Without values")
            ->setData(array(6, 24, 11, 26, 32, 6, 39, 37, 15, 12, 30, 24, 2, 38, 14))
            ->setBarWidth(20)
            ->setBarMargin(5)
            ->showValues(false);
        echo $graph->render();

        $graph = new SimpleBars();
        echo $graph->setTitle("Custom indices")->setData(array("a" => 15, "b" => 26, "C" => 2, "foo" =>28, 3 => 13))->render();

        $graph = new SimpleBars();
        $graph
            ->setTitle("Plain style")
            ->setData(array(14, 6, 26))
            ->setBarWidth(60)
            ->setBarMargin(10)
            ->showValues(false)
            ->showLabel(false);
        echo $graph->render();
        ?>

        <div class="styled">
            <?php
            $graph = new SimpleBars();
            $graph
                ->setTitle("Styled")
                ->setData(array("A" => 7, "B" => 39, "C" => 2, "D" => 26, "E" => 12))
                ->setBarWidth(40)
                ->setBarMargin(10);
            echo $graph->render();
            ?>
        </div>

    </body>
</html>
