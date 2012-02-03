String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
};


if(typeof String.prototype.trim !== 'function') {
    String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/, ''); 
    }
}