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

    getEventUrl() {
        var id = this.props.match.params.id_event;
        var API = '/api/events/' + id;
        return API;
    }

    isActive(elem) {
        console.log("active", elem);
        if (elem === 1) {
            return ('checked');
        }
    }


    render() {
        console.log(this.state.jsonData);
        return <div className="form_wrap panel view_panel">

            <div className="inner_form">
                <div className={"btn btn_create"}>
                    <Link to={"/eventUpdate/" + this.state.jsonData.id_event}>Изменить
                    </Link>
                </div>
                <div className={"btn btn_delete"}>
                    <Link to={"/eventDelete/" + this.state.jsonData.id_event}>Удалить
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
                        <label>Назначено на</label><br/>
                        <input type='text' className="datepicker-here form-control input_style" data-timepicker="true"
                               data-position="right top"/>
                    </p>
                    <form>
                        <p>Активно<input checked={this.isActive(this.state.jsonData.is_active)} type="checkbox"
                                         id={this.state.jsonData.id_event} className="status"/>
                        </p>
                    </form>
                </form>
            </div>
        </div>
    }
}

export default EventView;
