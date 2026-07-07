#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/wait.h>

float tarefa_A(float num1);
float tarefa_B(float num2);

int main(){
	int fd[2];
	pid_t pid;
	float n1 = 10.5, n2 = 20.5;

	if(pipe(fd) == -1){
		perror("Erro ao criar o pipe");
		return 1;
	}

	pid = fork();

	if (pid < 0){
		perror("Erro no fork");
		return 1;
	}

	if(pid == 0){
		close(fd[0]);
		float res_b = tarefa_B(n2);
		write(fd[1], &res_b, sizeof(res_b));
		close(fd[1]);
		exit(0);
	} else {
		close(fd[1]);
		float res_a = tarefa_A(n1);
		float res_b_recebido;

		read(fd[0], &res_b_recebido, sizeof(res_b_recebido));
		close(fd[0]);

		wait(NULL);
		
		float soma total = res_a + res_b_recebido;
		printf("Resultado final: %.2f\n", soma_total)
	}
	return 0;
}

float tarefa_A(float num1){return num1*2;}
float tarefa_B(float num2){return num2+5;}
