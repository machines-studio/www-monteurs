export default hash => {
  if (history.pushState) history.pushState(null, null, '#' + hash)
  else window.location.hash = hash
}
