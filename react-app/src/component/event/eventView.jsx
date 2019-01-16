import React, {Component} from 'react';
import {Link} from "react-router-dom";

class EventView extends Component {
    constructor(props) {
        super(props);
        this.state = {jsonData: ''};
    }

    componentWillMount() {
        fetch(this.getEventUrl())
            .then(response => response.json())
            .then(data => this.setState({jsonData: data.model}))
            .catch((error) => {
                console.error(error);
            });
    }


    getEventUrl() {
        var id = this.props.match.params.id_event;
        var API = '/api/events/' + id;
        return API;
    }

    render() {
        console.log(this.state);
        return <div className="form_wrap panel view_panel">
            <div className={"btn_create"}>
                <Link to="/eventForm">Создать событие</Link>
            </div>
            <div className="inner_form">
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
                    <input type="submit" value="Изменить"/>
                    <input type="submit" value="Удалить"/>

                </form>
            </div>
        </div>
    }
}

export default EventView;
