import React, {Component} from 'react';

class EventUpdate extends Component {
    constructor(props) {
        super(props);
        this.state = {
            jsonData: {}
        };

        this.onMessageChange = this.onMessageChange.bind(this);
        this.onCreatedChange = this.onCreatedChange.bind(this);
        this.onDoerChange = this.onDoerChange.bind(this);
        this.onAssigmentChange = this.onAssigmentChange.bind(this);
        this.onVersionChange = this.onVersionChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    onMessageChange(e) {
        var val = e.target.value;
        this.setState({message: val});
    }

    onCreatedChange(e) {
        var val = e.target.value;
        this.setState({created: val});
    }

    onDoerChange(e) {
        var val = e.target.value;
        this.setState({id_doer: val});
    }

    onAssigmentChange(e) {
        console.log(e);
        this.setState({assigment: e});
    }

    onVersionChange(e) {
        var val = e.target.value;
        this.setState({version: val});
    }

    getEventUrl() {
        var id = this.props.match.params.id_event;
        var API = '/api/events/' + id;
        return API;
    }

    trasferData(jsonData) {
        var message = jsonData.message;
        var id_doer = jsonData.doer;
        var version = jsonData.version;
        var assigment = jsonData.assigment;
        var created = jsonData.created;
        this.setState({message, id_doer, version, assigment, created});
    }

    componentWillMount() {
        console.log('params', this.props.match.params.id_event);
        fetch(this.getEventUrl())
            .then(response => response.json())
            .then(data => this.setState({jsonData: data.model}))
            .catch((error) => {
                console.error(error);
            });
    }

    handleSubmit(e) {
        e.preventDefault();
        this.trasferData(this.state);
        fetch('http://localhost/api/events/' + this.state.jsonData.id_event, {
            method: 'PUT', body: JSON.stringify(
                {
                    message: this.state.message,
                    created: this.state.created,
                    id_doer: this.state.doer,
                    assigment: this.state.assigment,
                    version: this.state.version
                }), headers: {'content-type': 'application/json'}
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                let elem = document.getElementById('container');
                elem.innerText = data;
            })
            .catch(alert);
    }


      checked(elem) {
        console.log("active", elem);
        if (elem === 1) {
            return ('checked');
        }
    }

    render() {
        console.log("state", this.state);
        return (
            <div className="form_wrap panel">
                <div className="inner_form">
                    <form onSubmit={this.handleSubmit}>
                        <p>
                            <label>Сообщение</label><br/>
                            <input type="text" className="form-control input_style"
                                   placeholder={this.state.jsonData.message}
                                   onChange={this.onMessageChange}/>
                        </p>
                        <p>
                            <label>Исполнитель</label><br/>
                            <input type="text" className="form-control input_style"
                                   placeholder={this.state.jsonData.id_doer}
                                   onChange={this.onDoerChange}/>
                        </p>
                        <p>
                            <label>Назначение</label><br/>
                            <input type='text' className="datepicker-here form-control input_style"
                                   data-timepicker="true"
                                   data-position="right top"/>
                        </p>
                        <form>
                            <p>Активно<input checked={this.checked(this.state.jsonData.is_active)} type="checkbox"
                                             id={this.state.jsonData.id_event} className="status"/>
                            </p>
                        </form>
                        <input type="submit" value="Отправить"/>
                    </form>
                </div>
            </div>
        );
    }
}

export default EventUpdate;
