/**
 * Returns:
 * _ a string representing the element of the array that matches the regexp (if more than one match, the first one will be returned)
 * _ an empty string if none of the elements matches the regular expression.
 * 
 * Example:
 * var testValues = ["John", "12345", "John12345"];
 * document.write(testValues.searchByRegexp(/^[a-z]+[0-9]+$/i));  // John12345
 *
 * @param regExp regExp
 * @return string
 */
Array.prototype.searchByRegexp = function (regExp) {
    var ln = this.length;
    for(var i = 0; i < ln; i++) {
        if(regExp.test(this[i])) {
            return this[i] + "";
        }
    }
    // return an empty string if no matches are found
    return "";
};

/**
 * Array Remove - By John Resig (MIT Licensed)
 * 
 * N.B.: This method returns the length of the new array
 * N.B.: be careful at using this method in a loop becuase the
 *       array changes
 * 
 * 
 * // Remove the second item from the array
 * array.remove(1);
 * // Remove the second-to-last item from the array
 * array.remove(-2);
 * // Remove the second and third items from the array
 * array.remove(1,2);
 * // Remove the last and second-to-last items from the array
 * array.remove(-2,-1);
 */
Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};


if (!Array.prototype.indexOf)
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}