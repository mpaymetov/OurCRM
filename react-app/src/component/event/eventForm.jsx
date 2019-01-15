import React, {Component} from 'react';

class EventForm extends Component {
    constructor(props) {
        super(props);
        this.state = {
            message: "",
            created: "",
            doer: "",
            assigment: "",
            version: "",
        };

        this.onMessageChange = this.onMessageChange.bind(this);
        this.onCreatedChange = this.onCreatedChange.bind(this);
        this.onDoerChange = this.onDoerChange.bind(this);
        this.onAssigmentChange = this.onAssigmentChange.bind(this);
        this.onVersionChange = this.onVersionChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    validateAge(age) {
        return age >= 0;
    }

    validateName(name) {
        return name.length > 2;
    }

    onMessageChange(e) {
        console.log(e);
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

    handleSubmit(e) {
        e.preventDefault();
        fetch('http://localhost/api/events', {
            method: 'POST', body: JSON.stringify(
                {
                    message: this.state.message,
                    created: this.state.created,
                    doer: this.state.doer,
                    assigment: this.state.assigment,
                    version: this.state.version
                }), headers: {'content-type': 'application/json'}
        })
            .then(function (response) {
                alert(response.status); // 200
                return response.json();
            })
            .then(function (data) {
                alert(data);
                let elem = document.getElementById('container');
                elem.innerText = data;
            })
            .catch(alert);
    }


    render() {
        return (
            <div className="form_wrap panel">
                <div className="inner_form">
                <form onSubmit={this.handleSubmit}>
                    <p>
                        <label>Сообщение</label><br/>
                        <textarea type="text" className="form-control input_style" value={this.state.message}
                               onChange={this.onMessageChange}/>
                    </p>
                    <p>
                        <label>Исполнитель</label><br/>
                        <input type="text" className="form-control input_style" value={this.state.id_doer}
                               onChange={this.onDoerChange}/>
                    </p>
                    <p>
                        <label>Назначение</label><br/>
                        <input type='text' className="datepicker-here form-control input_style" data-timepicker="true"
                               data-position="right top"/>

                    </p>
                    <input type="submit" value="Отправить"/>

                </form>
                </div>
            </div>
        );
    }
}

export default EventForm;
