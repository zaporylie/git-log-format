<?php

namespace eiriksm\CosyComposer;

class ChangeLogData {

  /**
   * @var \eiriksm\GitLogFormat\ChangelogLine[]
   */
  private $lines = [];

  /**
   * ChangeLogData constructor.
   */
  public function __construct() {
  }

  /**
   * @param string $changelog_string
   */
  public static function createFromString($changelog_string) {
    $lines = explode("\n", $changelog_string);
    $data = new self();
    foreach ($lines as $line) {
      if (empty($line)) {
        continue;
      }
      // Line should now be formatted like this:
      // <shorthash> <commit message>
      $line_data = explode(' ', $line);
      // So first one is now commit hash. The rest is message.
      $commit = array_shift($line_data);
      // Then implode it back without the sha.
      // @todo. This seems like it could be done faster with regexp, but since I
      // am doing this huge upgrade with no internet, I can't really google
      // anything :o.
      $message = implode(' ', $line_data);
      $data->lines[] = new ChangelogLine($commit, $message);
    }
    return $data;
  }

  public function getAsMarkdown() {
    $output = '';
    foreach ($this->lines as $line) {
      $output .= sprintf("- [%s](https://github.com/Seldaek/monolog/commit/%s) %s\n", $line->getCommit(), $line->getCommit(), $line->getCommitMessage());
    }
    return $output;
  }

}
