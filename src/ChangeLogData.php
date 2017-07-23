<?php

namespace eiriksm\GitLogFormat;

class ChangeLogData {

  /**
   * @var \eiriksm\GitLogFormat\ChangeLogLine[]
   */
  private $lines = [];

  /**
   * @return string
   */
  public function getGitSource() {
    return $this->gitSource;
  }

  /**
   * @param string $gitSource
   */
  public function setGitSource($gitSource) {
    if ($this->gitSourceIsSupported($gitSource)) {
      $this->gitSource = $gitSource;
    }
  }

  /**
   * @var string
   */
  private $gitSource;

  protected function gitSourceIsSupported($git) {
    $suported_prefixes = [
      'https://github.com/',
      'https://git.drupal.org',
    ];
    foreach ($suported_prefixes as $prefix) {
      if (strpos($git, $prefix) === 0) {
        return TRUE;
      }
    }
    return FALSE;
  }

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
      // @todo. This seems like it could be done faster with regex, but since I
      // am doing this huge upgrade with no internet, I can't really google
      // anything :o.
      $message = implode(' ', $line_data);
      $data->lines[] = new ChangeLogLine($commit, $message);
    }
    return $data;
  }

  /**
   * @return string
   */
  public function getAsMarkdown() {
    $output = '';
    foreach ($this->lines as $line) {
      $force_no_link = FALSE;
      if ($this->gitSource) {
        try {
          $url = $this->getCommitUrl($this->getGitSource(), $line->getCommit());
          $output .= sprintf("- [%s](%s) %s\n", $line->getCommit(), $url, $line->getCommitMessage());
        }
        catch (\Exception $e) {
          $force_no_link = TRUE;
        }
      }
      if (!$this->gitSource || $force_no_link) {
        $output .= sprintf("- %s %s\n", $line->getCommit(), $line->getCommitMessage());
      }
    }
    return $output;
  }


  /**
   * @param $url
   * @param $commit
   *
   * @return string
   * @throws \Exception
   */
  protected function getCommitUrl($url, $commit) {
    $url_parsed = parse_url($url);
    switch ($url_parsed['host']) {
      case 'github.com':
        return sprintf('%s/commit/%s', $url, $commit);

      case 'git.drupal.org':
        $project_name = str_replace('/project/', '', $url_parsed['path']);
        return sprintf('http://cgit.drupalcode.org/%s/commit/?id=%s', $project_name, $commit);

      default:
        throw new \Exception('Git URL host not supported.');

    }
  }

}
