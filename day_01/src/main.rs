use lib;

fn main() {
    puzzle_1();
    puzzle_2();
}

fn puzzle_1() {
    let values = lib::lines_from_file("puzzle_input.txt");
    let mut previous_value = 0;
    let mut counter = 0;

    for value in values {
        let current_value = value.parse::<i32>().unwrap();

        if previous_value == 0 {
            previous_value = current_value;
            continue;
        }

        if current_value > previous_value {
            counter += 1;
        }

        previous_value = current_value;
    }

    println!("Solution puzzle 1: {:?}", counter);
}

fn puzzle_2() {
    let values = lib::lines_from_file("puzzle_input.txt");
    let mut iterator = 0;
    let mut previous_value = 0;
    let mut current_value: i32;
    let mut counter = 0;

    while iterator + 2 < values.len() {
        current_value = 0;
        for n in iterator..=(iterator + 2) {
            current_value += values[n].parse::<i32>().unwrap();
        }


        if previous_value == 0 {
            previous_value = current_value;
            continue;
        }

        if current_value > previous_value {
            counter += 1;
        }

        previous_value = current_value;
        iterator += 1;
    }

    println!("Solution puzzle 2: {:?}", counter);
}
