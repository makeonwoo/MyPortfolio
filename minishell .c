#include <stdio.h>
#include <fcntl.h>
#include <sys/stat.h>
#include <dirent.h>
#include <termio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <ctype.h>
#include <sys/types.h>
#include <time.h>
#include <sys/sysmacros.h>

int num_check(char* d_name){
	for(int i = 0; i<strlen(d_name);i++){
		if(isdigit(d_name[i])==0)
			return 0;
	}
	return 1;
}

void myps(){
	DIR *directory;
	struct dirent *entry =NULL;
	char proc_file[40],buffer[255],
		cmd[40],*tmp;
	int pid,uid=getuid();
	FILE *fp;
	struct stat lstat;
	if((directory =opendir("/proc")) ==NULL)
		perror("opendir error :");

	while((entry = readdir(directory)) !=NULL){
		strcpy(proc_file,"/proc/");
		if(num_check(entry->d_name)){
			strcat(proc_file,entry->d_name);
			strcat(proc_file,"/status");
			fp=fopen(proc_file,"r");
			
			if(fp ==NULL)
				printf("no file\n");
			while(fgets(buffer, 255,fp)!= NULL){
				tmp = strtok(buffer,":");
				if(strcmp("Name",tmp)== 0){
					tmp = strtok(NULL," ");
					strcpy(cmd,tmp);
				}
				if(strcmp("Pid",tmp) ==0){
					tmp = strtok(NULL," ");
					pid = atoi(tmp);
				}
				if(strcmp("Uid",tmp) ==0){
					tmp = strtok(NULL," ");
					if(uid == atoi(tmp))
					printf("cmd : %s pid : %d\n",cmd, pid);		
				}
			}
		}
	}
}

int mystat(char *argv){
	struct stat sb;
	
	if(lstat(argv, &sb) == -1){
		perror("lstat");
		exit(EXIT_FAILURE);
	}

	printf("ID of containing device: [%lx,%lx]\n",
			(long)major(sb.st_dev),(long) minor
			(sb.st_dev));
	printf("File type:                ");

	switch(sb.st_mode & S_IFMT){
		case S_IFBLK: printf("block device\n"); break;
		case S_IFCHR: printf("character device\n"); break;
		case S_IFDIR: printf("directory\n"); break;
		case S_IFIFO: printf("FIFO/pipe\n"); break;
		case S_IFLNK: printf("symlinke\n"); break;
		case S_IFREG: printf("regular file\n"); break;
		case S_IFSOCK: printf("socket\n"); break;
		default: printf("unknown?\n");
	}
	printf("I-node number:			%ld\n",(long) sb.st_ino);
	printf("Mode:				%lo\n (octal)\n",
			(unsigned long) sb.st_mode);
	printf("Link count 			%ld\n",(long)sb.st_nlink);
	printf("Ownership:			UID=%ld		GID=%ld\n", (long) sb.st_uid,	(long) sb.st_gid);
	
	printf("Perferred I/OO block size:	 %ld bytes\n", (long) sb.st_blksize);
	printf("File size:			%lld bytes\n",(long long)sb.st_size);
	printf("Blocks allocated:		%lld bytes\n",(long long)sb.st_blocks);
	printf("Last status change:	%s", ctime(&sb.st_ctime));
	printf("Last file access:	%s", ctime(&sb.st_ctime));
	printf("Last file modification:	%s", ctime(&sb.st_ctime));
}
void ls(){
	DIR *dir_info;
	struct dirent *dir_entry;
	int line_count=0;
	dir_info =opendir(".");
	if(NULL !=dir_info)
	{
		while(dir_entry = readdir(dir_info)){
		if(dir_entry->d_name[0] != 46){
			if(line_count==0)
				printf("%s        ", dir_entry->d_name);
			else if(line_count==1)
				printf("%10s      ", dir_entry->d_name);
			else if(line_count==2)
	 			printf("%20s      ", dir_entry->d_name);
			line_count++;	
		}	
			if(line_count==3){
			printf("\n");
			line_count=0;
			}
		}
		printf("\n");
		closedir(dir_info);
	}
}

void minicat(char* fi){
	FILE *fp;
	char buf;
	char *filename = NULL;
	
	filename = fi;

	fp = fopen(filename,"r");
	if(fp == NULL){
		printf("can't open %s\n",filename);
		return;
	}
	while (free){
		buf = fgetc(fp);
		printf("%c",buf);
		if(buf == EOF){
			printf("\n");
			break;
		}
	}
}
void pwd(){
	char cwd[1024];
	getcwd(cwd, sizeof(cwd));
	printf("%s\n",cwd);
}
void cd(char* filename){
	if(chdir(filename) == -1)
		printf("cd fail \n");
}
void mycp(char old[40],char new[40]){
	char ch;
	int src,dst,file_permission=0;
	struct stat old_stat;

	stat(old, &old_stat);
	file_permission=old_stat.st_mode;
	src = open(old,O_RDONLY);
	dst = open(new,O_WRONLY | O_CREAT | O_TRUNC,file_permission);
	while(read(src,&ch,1))
		write(dst, &ch,1);
	close(src);
	close(dst);
}
int main()
{
	char st[40], history[200][40],
       		alias[200][40],al_command[200][40],old[40],new[40];
	char *order, *tmp;
	int t_n, check =0, count = 0,alias_count =0,alias_tmp_count,history_num,c=0;
	
	do{
		scanf("%[^\n]s", st);
		getchar();
		if(st[0] == 33){
			order = strtok(st,"!");
			history_num = atoi(order)-1;
				if(history_num >count)
				printf("no record");
				else{
				strcpy(st,history[history_num]);
				strcpy(history[count], st);
				order = strtok(st," ");
				}
			}
		else{
			strcpy(history[count], st);
			order = strtok(st," ");
		}
		for(int i =0; i<alias_count; i++){
			if(strcmp(order,alias[i]) ==0){
				strcpy(st,al_command[i]);	
				order = strtok(st," ");
			}
		}

		if(strcmp(order,"cat") == 0){
				order =strtok(NULL," ");
			while (order != NULL){
				minicat(order);
				order =strtok(NULL," ");
			}
		}
		else if(strcmp(order,"alias") == 0){
			order =strtok(NULL,"=");
			if(order != NULL){
				if(alias_count > 0){
					for(int j=0; j<alias_count; j++){
						if(strcmp(order,alias[j])==0){
							alias_tmp_count = j;
							check++;
							break;
						}
						else alias_tmp_count = alias_count;
					}
				}
				strcpy(alias[alias_count],order);
				order =strtok(NULL,"=");	
			if(order != NULL){
				if(order[0] == 34 || order[0] == 39){
				c=0;
					do{
						order[c] = order[c+1];	
						c++;
						if(order[c+1] == 34 || order[c+1] == 39){
							order[c] ='\0';
							strcpy(al_command[alias_tmp_count],order);
							alias_count++;
							alias_count= alias_count - check;
							check=0;
							break;
						}
						if(order[c] == 3){
							printf("alias input error\n");
							break;
						}
					}while(1);
				}
				else printf("alias input error\n");
			}
			else printf("alias input error\n");
			}
			else {
				if(alias_count>0){
					for(int ac =0; ac<alias_count; ac++)
						printf("%s=\"%s\"\n",alias[ac],al_command[ac]);
				}
				else
					printf("no record alias\n");
			}
		}
		else if(strcmp(order,"mkdir") ==0){
			order =strtok(NULL," ");
			mkdir(order, 0755);
		}
		else if(strcmp(order,"cd") ==0){	
			order =strtok(NULL," ");
			cd(order);		
		}
		else if(strcmp(order,"pwd") == 0)
			pwd();
		else if(strcmp(order,"ls") == 0)
			ls();	
		else if(strcmp(order,"history") == 0){
			count++;
			strcpy(history[count],"now");
			count=0;
			do{	
				printf("%d :",count+1);
				printf("%s\n",history[count]);
				count++;
			}while(strcmp(history[count],"now") != 0);
			count--;
		}
		else if(strcmp(order,"stat") == 0){
			order =strtok(NULL," \n");
			mystat(order);
		}
		else if(strcmp(order,"ln") == 0){
			order =strtok(NULL," ");
			strcpy(old,order);
			order =strtok(NULL," ");
			strcpy(new,order);
			if(link(old,new) == -1)
				printf("link fail\n");	
		}
		else if(strcmp(order,"rm") == 0){
			order = strtok(NULL," ");
			if(remove(order) != 0)
				printf("rm fail\n");	
		}
		else if(strcmp(order,"ps") == 0)
			myps();
		else if(strcmp(order,"cp") == 0){
			order =strtok(NULL," ");
			strcpy(old,order);
			order =strtok(NULL," ");
			strcpy(new,order);
			mycp(old,new);	
		}
		else if(strcmp(order,"chmod") == 0){
			order = strtok(NULL," ");
			t_n = strtol(order,NULL,8);
			order = strtok(NULL," ");
			if(chmod(order,t_n) != 0)
				printf("chmod fail");
		}
		count++;
	}while(strcmp(st,"exit") != 0);
	return 0;
}


