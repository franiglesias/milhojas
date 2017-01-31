var ProgressBar = React.createClass({
    render: function() {
        var percentage = Math.round(this.props.current * this.props.max / this.props.total);
        var progressStyle = {
            width: percentage + '%'
        };

        return (
            <div id="payroll-progress" className="success progress" role="progressbar" aria-valuenow={this.props.current} aria-valuemin={this.props.min} aria-valuemax="100">
                <span className="progress-meter" style={progressStyle}>
                    <p className="progress-meter-text">{percentage}%</p>
                </span>
            </div>
        );
    }
});
