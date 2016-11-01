function Progress() {

  this.update = function (data) {
    this.current = data.current;
    this.total = data.total;
    this.sent = data.sent;
    this.notFound = data.notFound;
    this.failed = data.failed;
  }

  this.asPCT = function() {
    return Math.round(100*this.current/this.total).toString()+'%';
  };

  this.employeeCount = function() {
    return this.current+'<small>/'+this.total+'</small>';
  };

  this.thereArePending = function() {
    return this.current < this.total;
  }
};
