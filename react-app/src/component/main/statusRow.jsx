import React, {Component} from 'react';
import FirstColumn from './firstColumn.jsx';
import SecondColumn from './secondColumn.jsx';
import ThirdColumn from './thirdColumn.jsx';
import FourthColumn from './fourthСolumn.jsx';
import FifthColumn from './fifthColumn.jsx';

class StatusRow extends Component {
    constructor(props) {
        super(props);
        this.state = {data: this.props.data};
    }

    render() {
        return (
            <div className={"row"}>
                <div className={"col-md-2 col-md-offset-1 status_column"}>
                    <div className={"status_name panel"}>
                        <div className={"inner_status_name first_column"}><p>Установление контакта</p></div>
                    </div>
                    <FirstColumn column={this.state.data[0]}/>
                </div>
                <div className={"col-md-2 col-sm-4 status_column"}>
                    <div className={"status_name panel"}>
                        <div className={"inner_status_name second_column"}><p>Выявление потребностей</p></div>
                    </div>
                    <SecondColumn column={this.state.data[1]}/>
                </div>
                <div className={"col-md-2 col-sm-4 status_column"}>
                    <div className={"status_name panel"}>
                        <div className={"inner_status_name third_column"}><p>Выставление счета</p></div>
                    </div>
                    <ThirdColumn column={this.state.data[2]}/>
                </div>

                <div className={"col-md-2 col-sm-4 status_column"}>
                    <div className={"status_name panel"}>
                        <div className={"inner_status_name fourth_column"}><p>Оплата</p></div>
                    </div>
                    <FourthColumn column={this.state.data[3]}/>
                </div>
                <div className={"col-md-2 col-sm-4 status_column"}>
                    <div className={"status_name panel"}>
                        <div className={"inner_status_name fifth_column"}><p>Поставка</p></div>
                    </div>
                    <FifthColumn column={this.state.data[4]}/>
                </div>
            </div>
        )
    }
}

export default StatusRow;

/**    **/