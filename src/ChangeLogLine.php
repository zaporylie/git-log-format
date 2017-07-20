<?php

namespace eiriksm\GitLogFormat;

class ChangelogLine {
  private $commit;
  private $commitMessage;

  public function __construct($commit, $commit_mesage) {
    $this->commit = $commit;
    $this->commitMessage = $commit_mesage;
  }

  /**
   * @return mixed
   */
  public function getCommit() {
    return $this->commit;
  }

  /**
   * @return mixed
   */
  public function getCommitMessage() {
    return $this->commitMessage;
  }
}
