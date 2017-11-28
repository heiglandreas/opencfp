<?php

/**
 * Copyright (c) 2013-2017 OpenCFP
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/opencfp/opencfp
 */

namespace OpenCFP\Domain\Talk;

use OpenCFP\Domain\Model\Talk;

class TalkSubmission
{
    private $data;

    public static function fromNative(array $data): self
    {
        $instance = new static();

        $instance->guardTitleIsAppropriateLength($data);
        $instance->guardDescriptionIsProvided($data);
        $instance->guardTalkTypeIsValid($data);
        $instance->guardLevelIsValid($data);
        $instance->guardCategoryIsValid($data);

        $instance->data = $data;

        return $instance;
    }

    public function toTalk(): Talk
    {
        $data = \array_merge([
            'title'       => '',
            'description' => '',
            'type'        => '',
            'level'       => '',
            'category'    => '',
            'desired'     => '',
            'slides'      => '',
            'other'       => '',
            'sponsor'     => '',
            'user_id'     => '',
        ], $this->data);

        return new Talk($data);
    }

    private function guardTitleIsAppropriateLength($data)
    {
        if (!isset($data['title']) || empty($data['title'])) {
            throw new InvalidTalkSubmissionException('The title of the talk must be provided.');
        }

        $maxLength = 100;

        if (\strlen($data['title']) > $maxLength) {
            throw InvalidTalkSubmissionException::noValidTitle($maxLength);
        }
    }

    private function guardDescriptionIsProvided($data)
    {
        if (!isset($data['description']) || empty($data['description'])) {
            throw new InvalidTalkSubmissionException('The description of the talk must be included.');
        }
    }

    private function guardTalkTypeIsValid($data)
    {
        if (!isset($data['type']) || empty($data['type'])) {
            throw new InvalidTalkSubmissionException('You must choose what type of talk you are submitting.');
        }

        if (!$this->isValidTalkType($data['type'])) {
            throw InvalidTalkSubmissionException::noValidTalkType();
        }
    }

    /**
     * Tells whether or not a talk type is supported / valid.
     *
     * This would be a good place to add user-configuration of acceptable
     * types of talks. We would inject some configuration in the factory method
     * that might drive this.
     *
     * @param $type
     *
     * @return bool true if it is valid, false otherwise
     */
    private function isValidTalkType($type)
    {
        return \in_array($type, ['regular', 'tutorial']);
    }

    private function guardLevelIsValid($data)
    {
        if (!isset($data['level']) || empty($data['level'])) {
            throw new InvalidTalkSubmissionException('You must choose when level of talk you are submitting.');
        }

        if (!$this->isValidLevel($data['level'])) {
            throw InvalidTalkSubmissionException::noValidLevel();
        }
    }

    private function isValidLevel($level)
    {
        return \in_array($level, ['entry', 'mid', 'advanced']);
    }

    private function guardCategoryIsValid($data)
    {
        if (!isset($data['category']) || empty($data['category'])) {
            throw new InvalidTalkSubmissionException('You must choose what category of talk you are submitting.');
        }

        if (!$this->isValidCategory($data['category'])) {
            throw InvalidTalkSubmissionException::noValidCategory();
        }
    }

    private function isValidCategory($category)
    {
        return \in_array($category, [
            'development',
            'framework',
            'database',
            'testing',
            'security',
            'devops',
            'api',
            'javascript',
            'uiux',
            'other',
            'continuousdelivery',
            'ibmi',
        ]);
    }
}
