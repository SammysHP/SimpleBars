<?php
/*
 * Copyright (C) 2013 Sven Karsten Greiner
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Creates simple bar graphs with HTML and CSS.
 *
 * @author Sven Karsten Greiner <sven@sammyshp.de>
 */
class SimpleBars {
    private $title = "";
    private $data = array();
    private $maxValue = 0;

    private $pecision = 0;
    private $outerMin = 20;

    private $autoMaxValue = true;

    private $showLabel = true;
    private $showTitle = false;
    private $showValues = true;
    private $hideNullValue = true;

    private $barWidth = 30;
    private $barMargin = 15;
    private $graphHeight = 200;

    /**
     * Set the data to be shown.
     *
     * @param float[] $data Associative array of values
     * @return SimpleBars this
     */
    public function setData(array $data) {
        $this->data = $data;
        return $this;
    }

    /**
     * Set the title of the graph.
     *
     * The title will be rendered automatically. You can disable it later with SimpleBars::showTitle().
     *
     * @see SimpleBars::showTitle()
     * @param string $title The title
     * @return SimpleBars this
     */
    public function setTitle($title) {
        $this->title = (string) $title;
        $this->showTitle(true);
        return $this;
    }

    /**
     * Set if title should be shown or not.
     *
     * @param boolean $value If true, title will be shown
     * @return SimpleBars this
     */
    public function showTitle($value) {
        $this->showTitle = (boolean) $value;
        return $this;
    }

    /**
     * Set if label should be shown or not.
     *
     * @param boolean $value If true, label will be shown
     * @return SimpleBars this
     */
    public function showLabel($value) {
        $this->showLabel = (boolean) $value;
        return $this;
    }

    /**
     * Set if values should be shown or not.
     *
     * @param boolean $value If true, values will be shown
     * @return SimpleBars this
     */
    public function showValues($value) {
        $this->showValues = (boolean) $value;
        return $this;
    }

    /**
     * Set the width of each bar in px.
     *
     * @param int $width Width in px
     * @return SimpleBars this
     */
    public function setBarWidth($width) {
        $this->barWidth = (int) $width;
        return $this;
    }

    /**
     * Set the margin of each bar in px.
     *
     * @param int $margin Margin in px
     * @return SimpleBars this
     */
    public function setBarMargin($margin) {
        $this->barMargin = (int) $margin;
        return $this;
    }

    /**
     * Set the maximum value of the graph manually.
     *
     * Larger values will be clipped.
     *
     * @see SimpleBars::autoMaxValue()
     * @param float $value The maximum value of the graph
     * @return SimpleBars this
     */
    public function setMaxValue($value) {
        $this->maxValue = (float) $value;
        $this->autoMaxValue(false);
        return $this;
    }

    /**
     * Set if the maximum value should be detected automatically or not.
     *
     * @see SimpleBars::setMaxValue()
     * @param boolean $value If true, the maximum value will be detected automatically
     * @return SimpleBars this
     */
    public function autoMaxValue($value) {
        $this->autoMaxValue = (boolean) $value;
        return $this;
    }

    /**
     * Set the height of the graph in px.
     *
     * This value does not include title and label.
     *
     * @param int $height Height in px
     * @return SimpleBars this
     */
    public function setGraphHeight($height) {
        $this->graphHeight = (int) $height;
        return $this;
    }

    /**
     * Set the precision used for shown values.
     *
     * E.g. 2 means 2 positions after decimal point.
     *
     * @param int $precision Precision
     * @return SimpleBars this
     */
    public function setPrecision($precision) {
        $this->precision = (int) $precision;
        return $this;
    }

    /**
     * Set the minimum height of a bar where the value will be shown inside of it.
     *
     * @param int $height Height in px
     * @return SimpleBars this
     */
    public function setOuterMin($height) {
        $this->outerMin = (int) $height;
        return $this;
    }

    /**
     * Set if null values should be shown or not.
     *
     * @param int $value If true, values will not be shown when equal 0
     * @return SimpleBars this
     */
    public function hideNullValue($value) {
        $this->hideNullValue = (boolean) $value;
        return $this;
    }

    /**
     * Render the graph with previously set data and configuration.
     *
     * @return string HTML of the graph
     */
    public function render() {
        $html = '<div class="graph">';

        if ($this->showTitle) {
            $html .= '<div class="title">' . $this->title . '</div>';
        }

        $values = array_values($this->data);
        $labels = array_keys($this->data);
        $maxValue = $this->autoMaxValue ? max($values) : $this->maxValue;
        $maxValue = $maxValue < 1 ? 1 : $maxValue;
        $left = $this->barMargin;

        $graphHeight = $this->graphHeight + $this->barMargin;
        $graphWidth = count($values) * ($this->barWidth + $this->barMargin) + $this->barMargin;

        $html .= '<ol class="data" style="width: ' . $graphWidth . 'px; height: ' . $graphHeight . 'px;">';
        foreach ($values as $value) {
            $height = floor($value / $maxValue * $this->graphHeight);

            $html .= '<li class="bar" style="left: ' . $left . 'px; height: ' . $height . 'px; width: ' . $this->barWidth . 'px;">';
            if ($this->showValues && ($this->showNullValue || $value > 0)) {
                $html .= '<span class="value' . ($height < $this->outerMin ? " outer" : "") . '">' . round($value, $this->precision) . '</span>';
            }
            $html .= '</li>';

            $left += $this->barWidth + $this->barMargin;
        }
        $html .= '</ol>';

        if ($this->showLabel) {
            $margin = floor($this->barMargin / 2);
            $width = $this->barWidth + $this->barMargin;

            $html .= '<ol class="label" style="margin-left: ' . $margin . 'px;">';
            foreach ($labels as $label) {
                $html .= '<li style="width: ' . $width . 'px;">' . $label . '</li>';
            }
            $html .= '</ol>';
        }

        $html .= '</div>';
        return $html;
    }
}
