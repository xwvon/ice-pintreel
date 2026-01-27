#!/bin/bash

# Set the target archive file name and path
archive_file="changed_files_$(date +%Y%m%d_%H%M%S).tar.gz"
archive_path="./$archive_file"

# Delete the archive file if it already exists
if [ -f "$archive_path" ]; then
  echo "Deleting existing archive file: $archive_path"
  rm "$archive_path"
fi

# Get the list of changed files between the current and previous commits
changed_files=$(git diff --name-only HEAD^ HEAD)

# Archive the changed files
echo "Archiving changed files to: $archive_path"
tar -czvf "$archive_path" $changed_files

echo "Done."
