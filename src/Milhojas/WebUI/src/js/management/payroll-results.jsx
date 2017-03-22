var NewButton = React.createClass({
    render: function() {
        if (this.props.show) {
            return (
                <p id="allow-new">
                <a href="{ this.props.url }" className="hollow button expanded">¿Deseas enviar otra nómina?</a>
                </p>
            );
        }
        return (
            <span></span>
        );
    }
});

var StatsBox = React.createClass({
    render: function() {
        return (
            <div className="row small-up-2 medium-up-4 large-up-4 collapse">
                <div className="column stats-display info">
                    <p className="header">
                        <i className="fi-torsos-all"></i>Empleados</p>
                    <p id='payroll-employee' className="body">{this.props.current}<small>/{this.props.total}</small></p>
                </div>
                <div className="column stats-display success">
                    <p className="header">Enviados</p>
                    <p id='payroll-sent' className="body">{this.props.sent}</p>

                </div>
                <div className="column stats-display warning">
                    <p className=" header">No se encontró</p>
                    <p id='payroll-not-found' className="body">{this.props.notfound}</p>

                </div>
                <div className="column stats-display alert">
                    <p className="header">No se envió</p>
                    <p id='payroll-failed' className="body">{this.props.notsent}</p>
                </div>
            </div>

        );
    }
});

var ProgressData = React.createClass({
    getInitialState: function() {
        return {
            current: 0,
            total: 0,
            sent: 0,
            notFound: 0,
            failed: 0,
            end: false
        };
    },
    getData: function() {
        $.getJSON(this.props.exchange)
        .done(function(data) {
            this.setState({
                current: data.current,
                total: data.total,
                sent: data.sent,
                notFound: data.notFound,
                failed: data.failed,
            });
            if (this.state.current > 0) {
                if (this.state.current >= this.state.total) {
                    clearInterval(this.state.started);
                    this.state.end = true;
                }
            }
        }.bind(this)).fail(function(data) {

        }).always(function(data){

        });
    },
    componentDidMount: function() {
        this.getData();
        this.state.started = setInterval(this.getData, 500);
    },

    render: function() {
        return (
            <div>
                <NewButton show={this.state.end} url={this.props.redirect}/>
                <ProgressBar min ='0' max ='100' current={this.state.current} total={this.state.total} />
                <StatsBox current={this.state.current} total={this.state.total} sent={this.state.sent} notfound={this.state.notFound} notsent={this.state.failed} />
            </div>
        )

    }
});
