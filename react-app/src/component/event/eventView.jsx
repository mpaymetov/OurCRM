import React, {Component} from 'react';
import {Link} from "react-router-dom";

class EventView extends Component {
    constructor(props) {
        super(props);
        this.state = {jsonData: '', active: ''};
    }

    componentWillMount() {
        fetch(this.getEventUrl())
            .then(response => response.json())
            .then(data => this.setState({jsonData: data.model}))
            .catch((error) => {
                console.error(error);
            });
    }

    cnahgeStatus() {
        console.log(this.props.match.params.id_event);
        if (this.state.active === '') {
            fetch('http://localhost/api/events/' + this.props.match.params.id_event, {
                method: 'POST', body: JSON.stringify(
                    {
                        active: this.state.active
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
    }

    getEventUrl() {
        var id = this.props.match.params.id_event;
        var API = '/api/events/' + id;
        return API;
    }

    render() {
        console.log(this.state);
        return <div className="form_wrap panel view_panel">

            <div className="inner_form">
                <div className={"btn_create"}>
                    <Link to={"/eventUpdate/" + this.state.jsonData.id_event}>Изменить
                </Link>
            </div>
            <form onSubmit={this.handleSubmit}>
                <p>
                    <label>Сообщение</label><br/>
                    <input type="text" className="form-control input_style" value={this.state.jsonData.message}/>
                </p>
                <p>
                    <label>Создано</label><br/>
                    <input type="text" className="form-control input_style" value={this.state.jsonData.created}/>
                </p>
                <p>
                    <label>Исполнитель</label><br/>
                    <input type="text" className="form-control input_style" value={this.state.jsonData.id_doer}/>
                </p>
                <p>
                    <label>назначение</label><br/>
                    <input type='text' className="datepicker-here form-control input_style" data-timepicker="true"
                           data-position="right top"/>
                </p>
                <form>
                    <p>Активно<input type="checkbox" id={this.state.jsonData.id_event} className="status"
                                     onChange={this.cnahgeStatus}/>
                    </p>
                </form>
                <input type="submit" value="Изменить"/>
                <input type="submit" value="Удалить"/>

            </form>
        </div>
    </div>
    }
}

export default EventView;
