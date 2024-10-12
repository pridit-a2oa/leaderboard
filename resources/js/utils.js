/**
 * Determines if the given object has the highest score among a filtered list of
 * characters (array of objects).
 *
 * @param {Array<Object>} array - The array of objects (characters) to filter
 *                                and compare.
 * @param {Object} object - The object (character) to compare with.
 *
 * @returns {boolean} - Returns `true` if the object has the highest score or is
 *                      most recently seen among objects with the highest score.
 *                      Returns `false` if the object is hidden or does not meet
 *                      the conditions.
 */
export function isHighestScore(array, object) {
  if (object.is_hidden) return false;

  // Filter relevant characters (visible, linked, matching guid)
  const filter = array.filter(
    (e) => !e.is_hidden && e.user_id !== undefined && e.guid === object.guid,
  );

  const score = Math.max(...filter.map((e) => e.score));

  // Highest unique score is associated with one character, so return early
  if (filter.filter((e) => e.score === score).length === 1)
    return score === object.score;

  // Multiple characters share the highest score, filter by last seen
  return (
    Math.max(...filter.map((e) => new Date(e.last_seen_at))) ===
    new Date(object.last_seen_at).getTime()
  );
}
