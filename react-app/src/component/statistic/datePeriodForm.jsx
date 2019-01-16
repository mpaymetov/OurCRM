import React, {Component} from 'react'


class DatePeriodForm extends Component{

    constructor(props) {
        super(props);
        this.state = {
            from: "",
            to: "",
            user: "",
            type: "",
        };

        this.initType = this.initType.bind(this);
        this.onFromChange = this.onFromChange.bind(this);
        this.onToChange = this.onToChange.bind(this);
        this.onUserChange = this.onUserChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    initType() {
        var val = this.props.info.type;
        this.setState({type: val});
    }

    onFromChange(e) {
        console.log(e);
        var val = e.target.value;
        this.setState({from: val});
    }

    onToChange(e) {
        console.log(e);
        var val = e.target.value;
        this.setState({to: val});
    }

    onUserChange(e) {
        console.log(e);
        var val = e.target.value;
        this.setState({user: val});
    }

    handleSubmit(e) {

    }

    isServiceset() {
        return (this.props.info.type == "serviceset");
    }

    isHeadStatistic() {
        return (this.props.info.form.statisticType == "headStatistic");
    }

    componentWillMount(){
        this.initType();
    }

    renderManagerForm() {
        return(<div className="panel date-period-form">
            <div className="inner_form">
                <form onSubmit={this.handleSubmit} className={"form-inline"}>
                    <div className={"form-group"}>
                        <label>С</label>
                        <input type="text" name="to" className="datepicker-here form-control input_style"
                               data-position="right top" value={this.state.to} onChange={this.onToChange}/>
                    </div>
                    <div className={"form-group"}>
                        <label>По</label>
                        <input type="text" name="to" className="datepicker-here form-control input_style"
                               data-position="right top" value={this.state.to} onChange={this.onToChange}/>
                    </div>
                    <input type="submit" className={"btn btn-default"} value="Отправить"/>
                </form>
            </div>
        </div>);
    }

    //value={this.state.from} onChange={this.onToChange}
    //value={this.state.to} onChange={this.onToChange}

    renderHeadForm() {
        return(
            <div className="panel date-period-form">
            <div className="inner_form">
                <form onSubmit={this.handleSubmit} className={"form-inline"}>
                    <div className={"form-group"}>
                        <label>С</label>
                        <input type="text" name="to" className="datepicker-here form-control input_style"
                               data-position="right top" />
                    </div>
                    <div className={"form-group"}>
                        <label>По</label>
                        <input type="text" name="to" className="datepicker-here form-control input_style" data-position="right top"
                               />
                    </div>
                    <div className={"form-group"}>
                        <label>Менеджер</label>
                        <select name='user'  value={this.state.user} className={"form-control input_style"} onChange={this.onInputChange}>
                            {this.props.info.form.list.map((item) => <option value={item.id}>{item.name}</option>)}
                        </select>
                    </div>
                    <input type="submit" className={"btn btn-default"} value="Отправить"/>
                </form>
            </div>
        </div>);
    }



    render() {
        console.log(this.props);
        if(this.props.info !== '') {
            return (
                <div>
                    {this.isServiceset()
                        ? null
                        : (this.isHeadStatistic() ? this.renderHeadForm() : this.renderManagerForm())}

                </div>
            );
        } else {
            return(
                <div></div>
            );
        }
    }

}

export default DatePeriodForm;