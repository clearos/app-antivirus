#!/bin/bash
# Check if there are any malformed clamav databases and removed them.
#
# Example:
# LibClamAV Error: Can't load /var/lib/clamav/spear.ndb: Malformed database

rm -f /tmp/.clamav-check
touch /tmp/.clamav-check

# Return code, will return non-zero if malformed database found.
rc=0

while true; do
    malformed=$(clamscan /tmp/.clamav-check 2>&1 | egrep '^Lib.*: Malformed database$')
    if [ -z "$malformed" ]; then
        logger  -p local6.notice -t "antivirus" "signatures in working order"
        break
    fi
    filename=$(echo "$malformed" | sed -e 's/^Lib.*load \(.*\):.*/\1/I')
    logger  -p local6.notice -t "antivirus" "malformed database symlink removed: $filename"
    rm -f "$filename"
    rc=$[ $rc + 1 ]
done

rm -f /tmp/.clamav-check

exit $rc

# vi: ts=4
